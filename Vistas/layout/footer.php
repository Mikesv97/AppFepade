<!--**********************************
            Footer start
        ***********************************-->
<style>
.imgFooter{
    max-width:260px;
    margin-left: 18em;
}
.copy>p{
    color:white;
    margin-top: 1em;
}

.copy >p> span {
    color:gold;
    
}

.piePag{
    background-color:black;
    padding: 10px;
}

@media only screen and (max-width: 1199px) {
    .imgFooter{
        max-width:260px;
        margin-left: 4em;
        margin: 0 auto;
        display:block;
    }

    .copy>p{
        color:white;
        margin: 0 auto;
        display:block;
    }

}
</style>
    <div class="container-fluid">
        <div class="row justify-content-center align-items-center piePag">
            <div class="col-md-6 text-center">
                <img src="../recursos/multimedia/imagenes/logoFepade.png" class="imgFooter" alt="">
            </div>
            <div class="col-md-6 text-center copy">
                <p>
                    Copyright &copy; <?=  date("Y");?> FEPADE El Salvador | Diseñado por <span>Douglas Méndez y Alan Castillo</span>
                </p>
            </div>
        </div>
    </div>
        <!--**********************************
            Footer end
        ***********************************-->

        <!--**********************************
           Support ticket button start
        ***********************************-->

        <!--**********************************
           Support ticket button end
        ***********************************-->


    </div>
    <!--**********************************
        Main wrapper end
    ***********************************-->

    <!--**********************************
        Scripts
    ***********************************-->
    <!-- Datatable -->
    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.3/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.9/js/responsive.bootstrap4.min.js"></script>

    <!-- Required vendors -->
    <script src="../Recursos/vendor/global/global.min.js"></script>
    <script src="../Recursos/JS/scriptPlantilla/quixnav-init.js"></script>
    <script src="../Recursos/JS/scriptPlantilla/custom.min.js"></script>
    <script src="../Recursos/vendor/moment/moment.min.js"></script>
    <script src="../Recursos/vendor/pg-calendar/js/pignose.calendar.min.js"></script>
    <script src="../Recursos/JS/dashboard/dashboard-2.js"></script> 
    <script src="../Recursos/vendor/jquery-steps/build/jquery.steps.min.js"></script>
    <script src="../Recursos/vendor/jquery-validation/jquery.validate.min.js"></script>

    <!-- Form validate init -->
    <script src="../Recursos/js/plugins-init/jquery.validate-init.js"></script>
    <!-- Form step init -->
    <script src="../Recursos/js/plugins-init/jquery-steps-init.js"></script>

</body>

</html>