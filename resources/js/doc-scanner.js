import * as tf from '@tensorflow/tfjs';

let model;
const IMGSZ = 640;
const testImage = document.getElementById('test-image');
const overlay = document.getElementById('overlay');
const captureBtn = document.getElementById('capture-btn');
const ctx = overlay.getContext('2d');

let points = []; 
let draggingPoint = null;

async function loadAI() {
    try {
        model = await tf.loadGraphModel('/assets/images/models/doc-scanner/model.json');
        console.log("AI Ready");
    } catch (e) { console.error("AI Error", e); }
}

// 1. Logic Upload & Syncing
document.getElementById('image-upload').addEventListener('change', (e) => {
    const file = e.target.files[0];
    if (!file) return;

    document.getElementById('loading-spinner').classList.remove('hidden');
    const reader = new FileReader();
    
    reader.onload = (event) => {
        testImage.src = event.target.result;
        testImage.classList.remove('hidden');
        
        testImage.onload = () => {
            // Sesuai ukuran gambar yang tampil di layar (CSS client size)
            overlay.width = testImage.clientWidth;
            overlay.height = testImage.clientHeight;
            
            // Mengunci canvas tepat di atas gambar (mengatasi flexbox alignment)
            overlay.style.top = testImage.offsetTop + "px";
            overlay.style.left = testImage.offsetLeft + "px";

            runDetection();
        };
    };
    reader.readAsDataURL(file);
});

// 2. AI Detection dengan Letterbox Scaling
async function runDetection() {
    const input = tf.tidy(() => {
        // AI bekerja pada skala 640x640
        return tf.browser.fromPixels(testImage)
            .resizeBilinear([IMGSZ, IMGSZ])
            .div(255.0)
            .expandDims(0);
    });

    const predictions = model.execute(input);
    const data = await predictions.data();

    // Mapping koordinat dari 640x640 ke dimensi client (layar)
    points = [];
    for (let i = 0; i < 4; i++) {
        points.push({
            x: data[5 + i * 3] * (overlay.width / IMGSZ),
            y: data[6 + i * 3] * (overlay.height / IMGSZ)
        });
    }

    document.getElementById('loading-spinner').classList.add('hidden');
    document.getElementById('ai-status-text').innerText = "AI AKTIF - GESER TITIK JIKA KURANG PAS";
    document.getElementById('ai-status-dot').classList.replace('bg-slate-400', 'bg-emerald-500');
    
    drawPoints();
    captureBtn.disabled = false;
    tf.dispose([input, predictions]);
}

// 3. Draggable UI Logic
function drawPoints() {
    ctx.clearRect(0, 0, overlay.width, overlay.height);
    
    // Draw Polygon Lines
    ctx.beginPath();
    ctx.strokeStyle = '#3b82f6';
    ctx.lineWidth = 3;
    ctx.setLineDash([5, 5]); // Garis putus-putus agar terlihat modern
    ctx.moveTo(points[0].x, points[0].y);
    points.forEach(p => ctx.lineTo(p.x, p.y));
    ctx.closePath();
    ctx.stroke();
    ctx.setLineDash([]); // Reset garis

    // Draw Handles (Titik Merah)
    points.forEach((p, i) => {
        ctx.beginPath();
        ctx.arc(p.x, p.y, 14, 0, 2 * Math.PI);
        ctx.fillStyle = draggingPoint === i ? '#dc2626' : '#ef4444';
        ctx.fill();
        ctx.strokeStyle = 'white';
        ctx.lineWidth = 3;
        ctx.stroke();
        
        // Glow effect
        ctx.shadowBlur = 10;
        ctx.shadowColor = "rgba(0,0,0,0.3)";
    });
}

// Event Handlers for Dragging
overlay.addEventListener('mousedown', (e) => {
    const rect = overlay.getBoundingClientRect();
    const mx = e.clientX - rect.left;
    const my = e.clientY - rect.top;
    points.forEach((p, i) => {
        if (Math.hypot(p.x - mx, p.y - my) < 25) draggingPoint = i;
    });
});

window.addEventListener('mousemove', (e) => {
    if (draggingPoint === null) return;
    const rect = overlay.getBoundingClientRect();
    // Constraint: titik tidak bisa keluar area gambar
    points[draggingPoint].x = Math.max(0, Math.min(e.clientX - rect.left, overlay.width));
    points[draggingPoint].y = Math.max(0, Math.min(e.clientY - rect.top, overlay.height));
    drawPoints();
});

window.addEventListener('mouseup', () => draggingPoint = null);

// 4. Final Warp Perspective (OpenCV)
captureBtn.addEventListener('click', () => {
    // Ukuran output standar A4 (300 DPI approx)
    const outW = 1200;
    const outH = 1600;
    
    let src = cv.imread(testImage);
    let dst = new cv.Mat();
    
    // KUNCI: Skala ulang dari dimensi LAYAR ke dimensi ASLI GAMBAR
    const ratioX = testImage.naturalWidth / overlay.width;
    const ratioY = testImage.naturalHeight / overlay.height;

    let srcArr = [];
    points.forEach(p => srcArr.push(p.x * ratioX, p.y * ratioY));

    let srcCoords = cv.matFromArray(4, 1, cv.CV_32FC2, srcArr);
    let dstCoords = cv.matFromArray(4, 1, cv.CV_32FC2, [0, 0, outW, 0, outW, outH, 0, outH]);

    let M = cv.getPerspectiveTransform(srcCoords, dstCoords);
    // Gunakan INTER_LANCZOS4 agar hasil warp tajam dan tidak stretch
    cv.warpPerspective(src, dst, M, new cv.Size(outW, outH), cv.INTER_LANCZOS4);

    cv.imshow('output-canvas', dst);
    document.getElementById('result-area').classList.remove('hidden');
    document.getElementById('result-area').scrollIntoView({ behavior: 'smooth' });

    // Cleanup
    [src, dst, M, srcCoords, dstCoords].forEach(m => m.delete());
});

// Download Action
document.getElementById('download-btn')?.addEventListener('click', () => {
    const canvas = document.getElementById('output-canvas');
    const link = document.createElement('a');
    link.download = `Document_Scan_${Date.now()}.jpg`;
    link.href = canvas.toDataURL('image/jpeg', 0.9);
    link.click();
});

document.addEventListener('opencv-ready', () => {
    cv['onRuntimeInitialized'] = loadAI;
    if (cv.Mat) loadAI();
});