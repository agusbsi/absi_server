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

       a[href="#"] {
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
     </style>
     <section class="content">
       <div class="container-fluid">
         <div class="callout callout-info">
           <p> Marketing Analist </p>
         </div>
         <div class="row">
           <div class="col-md-3">
             <a href="<?= base_url('adm/Analist/dsi') ?>" title="DSI">
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
             <a href="<?= base_url('adm/Analist/pl') ?>" title="PL">
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
             <a href="#" title="Fitur">
               <div class="e-card inactive">
                 <div class="wave"></div>
                 <div class="wave"></div>
                 <div class="wave"></div>
                 <div class="infotop">
                   <img src="<?= base_url() ?>assets/img/marketing/tanya.svg" class="img" title="tanya"> <br>
                   Kosong
                   <div class="name">......</div>
                 </div>
               </div>
             </a>
           </div>
           <div class="col-md-3">
             <a href="#" title="Fitur">
               <div class="e-card inactive">
                 <div class="wave"></div>
                 <div class="wave"></div>
                 <div class="wave"></div>
                 <div class="infotop">
                   <img src="<?= base_url() ?>assets/img/marketing/tanya.svg" class="img" title="tanya"> <br>
                   Kosong
                   <div class="name">......</div>
                 </div>
               </div>
             </a>
           </div>
           <div class="col-md-3">
             <a href="#" title="Fitur">
               <div class="e-card inactive">
                 <div class="wave"></div>
                 <div class="wave"></div>
                 <div class="wave"></div>
                 <div class="infotop">
                   <img src="<?= base_url() ?>assets/img/marketing/tanya.svg" class="img" title="tanya"> <br>
                   Kosong
                   <div class="name">......</div>
                 </div>
               </div>
             </a>
           </div>
           <div class="col-md-3">
             <a href="#" title="Fitur">
               <div class="e-card inactive">
                 <div class="wave"></div>
                 <div class="wave"></div>
                 <div class="wave"></div>
                 <div class="infotop">
                   <img src="<?= base_url() ?>assets/img/marketing/tanya.svg" class="img" title="tanya"> <br>
                   Kosong
                   <div class="name">......</div>
                 </div>
               </div>
             </a>
           </div>
           <div class="col-md-3">
             <a href="#" title="Fitur">
               <div class="e-card inactive">
                 <div class="wave"></div>
                 <div class="wave"></div>
                 <div class="wave"></div>
                 <div class="infotop">
                   <img src="<?= base_url() ?>assets/img/marketing/tanya.svg" class="img" title="tanya"> <br>
                   Kosong
                   <div class="name">......</div>
                 </div>
               </div>
             </a>
           </div>
           <div class="col-md-3">
             <a href="#" title="Fitur">
               <div class="e-card inactive">
                 <div class="wave"></div>
                 <div class="wave"></div>
                 <div class="wave"></div>
                 <div class="infotop">
                   <img src="<?= base_url() ?>assets/img/marketing/tanya.svg" class="img" title="tanya"> <br>
                   Kosong
                   <div class="name">......</div>
                 </div>
               </div>
             </a>
           </div>

         </div>
       </div>
     </section>
     <script>
       $(document).ready(function() {

         $('#table_artikel').DataTable({
           order: [
             [0, 'asc']
           ],
           responsive: true,
           lengthChange: false,
           autoWidth: false,
         });
       })
     </script>