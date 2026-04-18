<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($title ?? config('app.name')) ?></title>
    <style>
        :root{
            --primary:#6f1d2c;--primary-dark:#4f1220;--secondary:#d8aa73;--secondary-soft:#f7ead9;
            --bg:#fffaf6;--surface:#fff;--surface-alt:#fff7f0;--line:#ead8c8;--text:#222;--muted:#6c6c6c;
            --success:#1d8f58;--danger:#b42318;--warning:#9a6700;--shadow:0 10px 30px rgba(0,0,0,.08);--radius:18px
        }
        *{box-sizing:border-box} body{margin:0;font-family:"Cairo",sans-serif;background:linear-gradient(180deg,#fffdfb,var(--bg));color:var(--text)}
        a{text-decoration:none;color:inherit} img{max-width:100%;display:block}
        .container{width:min(1180px,calc(100% - 32px));margin:auto}
        .topbar{background:linear-gradient(90deg,var(--primary-dark),var(--primary));color:#fff;padding:18px 0;box-shadow:var(--shadow);position:sticky;top:0;z-index:50}
        .topbar-row{display:flex;align-items:center;justify-content:space-between;gap:16px;flex-wrap:wrap}
        .brand strong{display:block;font-size:20px}.brand span{font-size:13px;opacity:.88}
        .nav-links{display:flex;gap:10px;flex-wrap:wrap;align-items:center}.nav-links a{padding:10px 14px;border-radius:999px;background:rgba(255,255,255,.1)}
        .nav-links a.active{background:#fff;color:var(--primary);font-weight:800}
        .page{padding:28px 0 40px}.card{background:var(--surface);border:1px solid var(--line);border-radius:var(--radius);box-shadow:var(--shadow)}
        .panel{padding:22px}.grid{display:grid;gap:18px}.stats{grid-template-columns:repeat(auto-fit,minmax(180px,1fr))}
        .stat{padding:20px}.stat strong{font-size:34px;color:var(--primary);display:block}.stat span{color:var(--muted)}
        .btn{border:none;border-radius:14px;padding:12px 16px;font-weight:800;cursor:pointer;display:inline-flex;align-items:center;justify-content:center;gap:8px}
        .btn-primary{background:var(--primary);color:#fff}.btn-light{background:#fff;border:1px solid var(--line)}.btn-danger{background:var(--danger);color:#fff}
        .btn-secondary{background:var(--secondary-soft);color:var(--primary);border:1px solid #f0d8b8}
        .flash{padding:14px 16px;border-radius:14px;margin:16px 0;font-weight:700}.flash-success{background:#e8f7ef;color:var(--success)}.flash-error{background:#fdecec;color:var(--danger)}
        .badge{display:inline-flex;padding:6px 12px;border-radius:999px;background:var(--secondary-soft);color:var(--primary);font-size:12px;font-weight:800}
        .login-shell{min-height:100vh;display:grid;place-items:center;padding:20px}.login-card{width:min(460px,100%);padding:28px}.form-group{margin-bottom:16px}
        label{display:block;margin-bottom:8px;font-weight:800}.input,.select,.textarea{width:100%;padding:14px 16px;border:1px solid var(--line);border-radius:14px;background:#fff;font-size:15px}
        .textarea{min-height:120px;resize:vertical}.muted{color:var(--muted)} .footer-note{margin-top:18px;color:var(--muted);font-size:13px}
        .toolbar{display:flex;align-items:center;justify-content:space-between;gap:14px;flex-wrap:wrap;margin-bottom:18px}.toolbar .actions{display:flex;gap:10px;flex-wrap:wrap}
        .table-wrap{overflow:auto}.table{width:100%;border-collapse:collapse;min-width:900px}.table th,.table td{padding:14px;border-bottom:1px solid var(--line);text-align:right;vertical-align:top}.table th{background:var(--surface-alt);font-size:14px}
        .status{display:inline-flex;align-items:center;gap:8px;padding:6px 10px;border-radius:999px;font-size:12px;font-weight:800}.status.active{background:#e8f7ef;color:var(--success)}.status.inactive{background:#f3f4f6;color:#667085}
        .chips{display:flex;gap:8px;flex-wrap:wrap}.chip{padding:6px 10px;border-radius:999px;background:#f8efe5;color:var(--primary);font-size:12px;font-weight:700}
        .form-grid{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:18px}.form-grid .full{grid-column:1/-1}
        .checkbox-wrap{display:flex;gap:10px;align-items:center;padding:14px 16px;border:1px solid var(--line);border-radius:14px;background:#fff}
        .hero-card{background:linear-gradient(135deg,rgba(111,29,44,.97),rgba(155,67,89,.92));color:#fff;padding:24px;border-radius:26px;box-shadow:var(--shadow)}
        .hero-card h1{margin:0 0 10px;font-size:30px}.hero-card p{margin:0;opacity:.92;line-height:1.9}
        .mini{font-size:13px;color:var(--muted)} .danger-zone{border:1px dashed rgba(180,35,24,.3);background:#fff7f7}
        .thumb{width:72px;height:72px;border-radius:14px;background:#f4ebe2;border:1px solid var(--line);display:grid;place-items:center;overflow:hidden}
        .thumb img{width:100%;height:100%;object-fit:cover}.empty-state{text-align:center;padding:34px}.empty-state h3{margin:0 0 8px}.empty-state p{margin:0;color:var(--muted)}
        .filter-grid{display:grid;grid-template-columns:1.1fr 1fr auto auto;gap:12px;align-items:end}
        .meta-list{display:grid;gap:8px}.meta-item{display:flex;gap:10px;align-items:center;color:var(--muted);font-size:14px}
        .split{display:grid;grid-template-columns:2fr 1fr;gap:18px}
        @media (max-width:900px){.form-grid,.split,.filter-grid{grid-template-columns:1fr}.table{min-width:760px}}
    </style>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
</head>
<body>
