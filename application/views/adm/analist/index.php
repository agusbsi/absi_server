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

       .playing .wave {
         border-radius: 50%;
         animation: wave 3000ms infinite linear;
       }

       .wave {
         border-radius: 20%;
         animation: wave 55s infinite linear;
       }

       .playing .wave:nth-child(2) {
         animation-duration: 4000ms;
       }

       .wave:nth-child(2) {
         animation-duration: 50s;
       }

       .playing .wave:nth-child(3) {
         animation-duration: 5000ms;
       }

       .wave:nth-child(3) {
         animation-duration: 45s;
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
             <a href="#" title="Fitur">
               <div class="e-card playing">
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
               <div class="e-card playing">
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
               <div class="e-card playing">
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
               <div class="e-card playing">
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
               <div class="e-card playing">
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
               <div class="e-card playing">
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
               <div class="e-card playing">
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
     <!-- jQuery -->
     <script src="<?= base_url() ?>/assets/plugins/jquery/jquery.min.js"></script>
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