<?php

$my_report = "C:\rptArticuloPorBodega.rpt";
$my_pdf = "C:\test.pdf";

try{
    $ObjectFactory = new COM("CrystalReports115.ObjectFactory.1");

    $crapp = $ObjectFactory->CreateObject("CrystalRuntime.Application.115");

    $creport = $crapp->OpenReport($my_report, 1);

    $creport->EnableParameterPrompting = 0;
    $creport->FormulaSyntax = 0;


    $creport->DiscardSavedData();
    $creport->RecordSelectionFormula = "{invoice.invoiceid} = 20070128114815";
    $creport->ReadRecords();

    $creport->ExportOptions->DiskFileName = $my_pdf;
    $creport->ExportOptions->FormatType = 31;
    $creport->ExportOptions->DestinationType=1;
    $creport->Export(false);

    $creport = null;
    $crapp = null;
    $ObjectFactory = null;
    }catch(com_exception $e){
        echo $e->getMessage();
    }


?>
