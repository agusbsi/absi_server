     <style>
       .e-card {
         margin: 10px auto;
         background: transparent;
         box-shadow: 0px 8px 28px -9px rgba(0, 0, 0, 0.45);
         position: relative;
         width: 200px;
         height: 210px;
         border-radius: 20px;
         overflow: hidden;
         transition: all 0.3s ease-in-out;
       }

       .e-card:hover {
         transform: translateY(-5px);
         box-shadow: 0px 12px 35px -9px rgba(0, 0, 0, 0.6);
       }

       /* Styling untuk card yang belum aktif */
       .e-card.inactive {
         background: linear-gradient(135deg, #e0e0e0 0%, #c5c5c5 100%);
         box-shadow: 0px 5px 15px -5px rgba(0, 0, 0, 0.15);
         border: 2px dashed #999999;
         opacity: 1;
       }

       .e-card.inactive:hover {
         transform: translateY(-5px) scale(1.02);
         box-shadow: 0px 10px 25px -5px rgba(0, 0, 0, 0.3);
         background: linear-gradient(135deg, #d0d0d0 0%, #b5b5b5 100%);
         border-color: #777777;
       }

       .e-card.inactive .infotop {
         color: #666666 !important;
       }

       .e-card.inactive .infotop img {
         opacity: 0.5;
         filter: grayscale(100%);
       }

       .e-card.inactive .wave {
         display: none;
       }

       .e-card.inactive::before {
         content: '🔒 Belum Tersedia';
         position: absolute;
         bottom: 10px;
         left: 0;
         right: 0;
         text-align: center;
         font-size: 11px;
         color: #888888;
         font-weight: 500;
         z-index: 10;
       }

       .analyst-page .module-link.is-disabled {
         cursor: not-allowed;
         pointer-events: none;
       }

       .wave {
         position: absolute;
         width: 540px;
         height: 700px;
         opacity: 0.6;
         left: 0;
         top: 0;
         margin-left: -50%;
         margin-top: -60%;
         background: linear-gradient(744deg, #007bff, #5b42f3 60%, #00ddeb);
       }

       .icon {
         width: 3em;
         margin-top: -1em;
         padding-bottom: 1em;
       }

       .infotop {
         text-align: center;
         font-size: 20px;
         position: absolute;
         top: 1.6em;
         left: 0;
         right: 0;
         color: rgb(255, 255, 255);
         font-weight: 600;
       }

       .name {
         font-size: 14px;
         font-weight: 100;
         position: relative;
         text-transform: lowercase;
       }

       .wave:nth-child(2),
       .wave:nth-child(3) {
         top: 100px;
       }

       /* Animasi wave hanya aktif saat hover pada card aktif */
       .e-card:not(.inactive):hover .wave {
         border-radius: 50%;
         animation: wave 3000ms infinite linear;
       }

       .e-card:not(.inactive):hover .wave:nth-child(2) {
         animation-duration: 4000ms;
       }

       .e-card:not(.inactive):hover .wave:nth-child(3) {
         animation-duration: 5000ms;
       }

       /* Wave default tanpa animasi */
       .wave {
         border-radius: 40%;
         animation: none;
       }

       @keyframes wave {
         0% {
           transform: rotate(0deg);
         }

         100% {
           transform: rotate(360deg);
         }
       }
       .analyst-page{--primary:#2563eb;--muted:#64748b;--line:#e2e8f0;color:#0f172a}.analyst-page .analyst-hero{display:flex;align-items:center;justify-content:space-between;padding:27px 29px;margin-bottom:20px;border-radius:20px;color:#fff;background:linear-gradient(125deg,#172554,#1d4ed8 72%,#38bdf8 140%);box-shadow:0 14px 35px rgba(30,64,175,.18)}.analyst-page .analyst-hero h2{margin:0 0 6px;font-size:26px;font-weight:700}.analyst-page .analyst-hero p{max-width:650px;margin:0;color:rgba(255,255,255,.78);font-size:12px}.analyst-page .hero-icon{display:flex;width:58px;height:58px;align-items:center;justify-content:center;border-radius:16px;background:rgba(255,255,255,.13);font-size:24px}.analyst-page .section-heading{display:flex;align-items:flex-end;justify-content:space-between;margin:4px 0 14px}.analyst-page .section-heading h3{margin:0 0 3px;font-size:17px;font-weight:700}.analyst-page .section-heading p{margin:0;color:var(--muted);font-size:11px}.analyst-page .module-count{padding:5px 10px;border-radius:20px;color:#1d4ed8;background:#eff6ff;font-size:10px;font-weight:700}
       .analyst-page .module-link{display:block;height:100%;color:inherit}.analyst-page .module-link:hover{text-decoration:none}.analyst-page .e-card{display:flex;width:100%;height:190px;align-items:flex-end;padding:20px;margin:0 0 20px;border:1px solid transparent;border-radius:17px;background:linear-gradient(145deg,#1d4ed8,#2563eb 60%,#0891b2);box-shadow:0 8px 24px rgba(30,64,175,.16)}.analyst-page .e-card:hover{transform:translateY(-4px);box-shadow:0 14px 30px rgba(30,64,175,.22)}.analyst-page .wave{display:none!important}.analyst-page .infotop{position:static;width:100%;color:#fff;text-align:left;font-size:20px}.analyst-page .infotop img{width:52px;height:52px;padding:10px;margin:0 0 19px;border-radius:14px;background:rgba(255,255,255,.14);object-fit:contain}.analyst-page .name{margin-top:5px;color:rgba(255,255,255,.75);font-size:11px;font-weight:500;text-transform:none}.analyst-page .e-card.inactive{border:1px dashed #cbd5e1;background:#f8fafc;box-shadow:none;opacity:1}.analyst-page .e-card.inactive:hover{border-color:#cbd5e1;background:#f8fafc;box-shadow:none;transform:none}.analyst-page .e-card.inactive .infotop{color:#64748b!important}.analyst-page .e-card.inactive .infotop img{opacity:.55;background:#e2e8f0;filter:grayscale(1)}.analyst-page .e-card.inactive .name{color:#94a3b8}.analyst-page .e-card.inactive:before{content:'Belum tersedia';right:18px;bottom:18px;left:auto;padding:4px 8px;border-radius:20px;color:#64748b;background:#e2e8f0;font-size:9px;font-weight:700}.analyst-page .info-panel{display:flex;padding:13px 15px;margin-top:2px;border:1px solid #bfdbfe;border-radius:12px;color:#475569;background:#eff6ff;font-size:11px}.analyst-page .info-panel i{margin:2px 9px 0 0;color:#2563eb}.analyst-page .info-panel strong{color:#1e3a8a}
       .analyst-page .e-card:not(.inactive){position:relative;isolation:isolate;background-size:160% 160%;background-position:0 50%;transition:transform .28s cubic-bezier(.22,1,.36,1),box-shadow .28s ease,background-position .5s ease}.analyst-page .e-card:not(.inactive):before{content:"";position:absolute;z-index:-1;top:-70%;left:-45%;width:48%;height:240%;border-radius:50%;background:linear-gradient(90deg,transparent,rgba(255,255,255,.2),transparent);transform:rotate(24deg) translateX(-180%);transition:transform .65s cubic-bezier(.22,1,.36,1)}.analyst-page .e-card:not(.inactive):after{content:"Buka analisis  \2192";position:absolute;right:18px;bottom:18px;padding:5px 9px;border:1px solid rgba(255,255,255,.18);border-radius:20px;color:#fff;background:rgba(255,255,255,.11);font-size:9px;font-weight:700;opacity:0;transform:translateX(-8px);transition:opacity .25s ease,transform .25s ease}.analyst-page .module-link:hover .e-card:not(.inactive),.analyst-page .module-link:focus-visible .e-card:not(.inactive){background-position:100% 50%;box-shadow:0 18px 38px rgba(30,64,175,.27);transform:translateY(-6px) scale(1.012)}.analyst-page .module-link:hover .e-card:not(.inactive):before,.analyst-page .module-link:focus-visible .e-card:not(.inactive):before{transform:rotate(24deg) translateX(470%)}.analyst-page .module-link:hover .e-card:not(.inactive):after,.analyst-page .module-link:focus-visible .e-card:not(.inactive):after{opacity:1;transform:translateX(0)}.analyst-page .e-card:not(.inactive) .infotop img{transition:transform .32s cubic-bezier(.22,1,.36,1),background-color .25s ease}.analyst-page .module-link:hover .e-card:not(.inactive) .infotop img{background:rgba(255,255,255,.2);transform:translateY(-3px) scale(1.08)}.analyst-page .module-link:focus-visible{outline:0}.analyst-page .module-link:focus-visible .e-card:not(.inactive){box-shadow:0 0 0 4px rgba(96,165,250,.35),0 18px 38px rgba(30,64,175,.22)}
       @media(max-width:767.98px){.analyst-page .analyst-hero{padding:22px}.analyst-page .analyst-hero h2{font-size:22px}.analyst-page .hero-icon{display:none}.analyst-page .section-heading{align-items:flex-start;flex-direction:column}.analyst-page .module-count{margin-top:7px}.analyst-page .e-card{height:170px}.analyst-page .e-card:not(.inactive):after{opacity:1;transform:none}}
       @media(prefers-reduced-motion:reduce){.analyst-page .e-card,.analyst-page .e-card:before,.analyst-page .e-card:after,.analyst-page .infotop img{transition:none!important}.analyst-page .module-link:hover .e-card:not(.inactive){transform:none}}
     </style>
     <section class="content analyst-page">
       <div class="container-fluid">
         <div class="analyst-hero"><div><h2>Marketing Analyst</h2><p>Pusat analisis perputaran persediaan dan potensi kehilangan penjualan untuk mendukung pengambilan keputusan.</p></div><div class="hero-icon"><i class="fas fa-chart-line"></i></div></div>
         <div class="section-heading"><div><h3>Modul Analisis</h3><p>Pilih modul yang ingin Anda gunakan.</p></div><span class="module-count">2 modul tersedia</span></div>
         <div class="row">
           <div class="col-md-3">
             <a class="module-link" href="<?= base_url('adm/Analist/dsi') ?>" title="Buka analisis DSI">
               <div class="e-card playing">
                 <div class="wave"></div>
                 <div class="wave"></div>
                 <div class="wave"></div>
                 <div class="infotop">
                   <img src="<?= base_url() ?>assets/img/marketing/dsi.svg" class="img" title="DSI"> <br>
                   DSI
                   <div class="name">Days Sales of Inventory</div>
                 </div>
               </div>
             </a>
           </div>
           <div class="col-md-3">
             <a class="module-link" href="<?= base_url('adm/Analist/pl') ?>" title="Buka analisis Potential Lost">
               <div class="e-card playing">
                 <div class="wave"></div>
                 <div class="wave"></div>
                 <div class="wave"></div>
                 <div class="infotop">
                   <img src="<?= base_url() ?>assets/img/marketing/pl.svg" class="img" title="PL"> <br>
                   PL
                   <div class="name">Potential Lost</div>
                 </div>
               </div>
             </a>
           </div>
           <div class="col-md-3">
             <a class="module-link is-disabled" href="#" title="Fitur belum tersedia" aria-disabled="true">
               <div class="e-card inactive">
                 <div class="wave"></div>
                 <div class="wave"></div>
                 <div class="wave"></div>
                 <div class="infotop">
                   <img src="<?= base_url() ?>assets/img/marketing/tanya.svg" class="img" title="tanya"> <br>
                   Segera Hadir
                   <div class="name">Modul analisis berikutnya</div>
                 </div>
               </div>
             </a>
           </div>
           <div class="col-md-3">
             <a class="module-link is-disabled" href="#" title="Fitur belum tersedia" aria-disabled="true">
               <div class="e-card inactive">
                 <div class="wave"></div>
                 <div class="wave"></div>
                 <div class="wave"></div>
                 <div class="infotop">
                   <img src="<?= base_url() ?>assets/img/marketing/tanya.svg" class="img" title="tanya"> <br>
                   Segera Hadir
                   <div class="name">Modul analisis berikutnya</div>
                 </div>
               </div>
             </a>
           </div>
           <div class="col-md-3">
             <a class="module-link is-disabled" href="#" title="Fitur belum tersedia" aria-disabled="true">
               <div class="e-card inactive">
                 <div class="wave"></div>
                 <div class="wave"></div>
                 <div class="wave"></div>
                 <div class="infotop">
                   <img src="<?= base_url() ?>assets/img/marketing/tanya.svg" class="img" title="tanya"> <br>
                   Segera Hadir
                   <div class="name">Modul analisis berikutnya</div>
                 </div>
               </div>
             </a>
           </div>
           <div class="col-md-3">
             <a class="module-link is-disabled" href="#" title="Fitur belum tersedia" aria-disabled="true">
               <div class="e-card inactive">
                 <div class="wave"></div>
                 <div class="wave"></div>
                 <div class="wave"></div>
                 <div class="infotop">
                   <img src="<?= base_url() ?>assets/img/marketing/tanya.svg" class="img" title="tanya"> <br>
                   Segera Hadir
                   <div class="name">Modul analisis berikutnya</div>
                 </div>
               </div>
             </a>
           </div>
           <div class="col-md-3">
             <a class="module-link is-disabled" href="#" title="Fitur belum tersedia" aria-disabled="true">
               <div class="e-card inactive">
                 <div class="wave"></div>
                 <div class="wave"></div>
                 <div class="wave"></div>
                 <div class="infotop">
                   <img src="<?= base_url() ?>assets/img/marketing/tanya.svg" class="img" title="tanya"> <br>
                   Segera Hadir
                   <div class="name">Modul analisis berikutnya</div>
                 </div>
               </div>
             </a>
           </div>
           <div class="col-md-3">
             <a class="module-link is-disabled" href="#" title="Fitur belum tersedia" aria-disabled="true">
               <div class="e-card inactive">
                 <div class="wave"></div>
                 <div class="wave"></div>
                 <div class="wave"></div>
                 <div class="infotop">
                   <img src="<?= base_url() ?>assets/img/marketing/tanya.svg" class="img" title="tanya"> <br>
                   Segera Hadir
                   <div class="name">Modul analisis berikutnya</div>
                 </div>
               </div>
             </a>
           </div>

         </div>
         <div class="info-panel"><i class="fas fa-info-circle"></i><div><strong>Informasi:</strong> Modul berlabel "Belum tersedia" sedang dalam pengembangan.</div></div>
       </div>
     </section>
