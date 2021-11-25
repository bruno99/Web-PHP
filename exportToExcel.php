<?php
include_once(".htconnection.php");
require_once('PHPExcel.php');

function export_excel_csv()
{

		$filenameDate = date('Y-m-d');
		if (isset($_POST['fecha'])){
			$filenameDate = $_POST['fecha'];
			$query="SELECT * FROM t_storage WHERE estado='CRT' AND f_creacion < (NOW() - INTERVAL 10 HOUR) AND f_creacion LIKE '".$filenameDate."%' ORDER BY cliente, reason, in_modelo";
			unset($_POST['fecha']);
		}
		else{
			$type = $_GET["ERROR"];
		}

		$result= mysql_query($query) or die(mysql_error());
		$objPHPExcel = new PHPExcel();
		$objPHPExcel->setActiveSheetIndex(0);
		$rowcount=1;
			$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getColumnDimension('M')->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getColumnDimension('N')->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getColumnDimension('O')->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getColumnDimension('P')->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getColumnDimension('Q')->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getColumnDimension('R')->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getColumnDimension('S')->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getColumnDimension('T')->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getColumnDimension('U')->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getColumnDimension('V')->setAutoSize(true);

		//Se escriben las cabeceras
		$objPHPExcel->getActiveSheet()->getStyle("A1:W1")->getFont()->setBold(true); //Primera fila en negrita
		$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowcount, "Cliente");
		$objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowcount, "Comentario");
		 $objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowcount, "RMA");
		 $objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowcount, "MC");
		 $objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowcount, "RNE");
		 $objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowcount, "Teléfono");
		 $objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowcount, "Calle");
		 $objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowcount, "CP");
		 $objPHPExcel->getActiveSheet()->SetCellValue('I'.$rowcount, "Población");
		 $objPHPExcel->getActiveSheet()->SetCellValue('J'.$rowcount, "Provincia");
		 $objPHPExcel->getActiveSheet()->SetCellValue('K'.$rowcount, "Origen");
		 $objPHPExcel->getActiveSheet()->SetCellValue('L'.$rowcount, "Razón");
		 $objPHPExcel->getActiveSheet()->SetCellValue('M'.$rowcount, "Almacen entrada");
		 $objPHPExcel->getActiveSheet()->SetCellValue('N'.$rowcount, "Modelo entrada");
		 $objPHPExcel->getActiveSheet()->SetCellValue('O'.$rowcount, "SN entrada");
		 $objPHPExcel->getActiveSheet()->SetCellValue('P'.$rowcount, "IMEI entrada");
		 $objPHPExcel->getActiveSheet()->SetCellValue('Q'.$rowcount, "Almacén salida");
		 $objPHPExcel->getActiveSheet()->SetCellValue('R'.$rowcount, "Modelo salida");
		 $objPHPExcel->getActiveSheet()->SetCellValue('S'.$rowcount, "SN salida");
		 $objPHPExcel->getActiveSheet()->SetCellValue('T'.$rowcount, "IMEI salida");
		 $objPHPExcel->getActiveSheet()->SetCellValue('U'.$rowcount, "ID");
		 $objPHPExcel->getActiveSheet()->SetCellValue('V'.$rowcount, "F. Creacion");
		 $rowcount++;



		while($row = mysql_fetch_array($result)){
			 $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowcount, utf8_encode($row['cliente']));
			 $objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowcount, utf8_encode($row['comentarios']));
			 $objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowcount, $row['rma']);
			 $objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowcount, $row['mc']);
			 $objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowcount, $row['nref']);
			 $objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowcount, $row['telefono']);
			 $objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowcount, utf8_encode($row['calle']));
			 $objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowcount, $row['cp']);
			 $objPHPExcel->getActiveSheet()->SetCellValue('I'.$rowcount, utf8_encode($row['poblacion']));
			 $objPHPExcel->getActiveSheet()->SetCellValue('J'.$rowcount, utf8_encode($row['provincia']));
			 $objPHPExcel->getActiveSheet()->setCellValueExplicit('K'.$rowcount, $row['origen']);
			 //Si hay part number se añade un "->" y se une a "DP3"
			 if ($row['reason'] == "DP3")
 				$partNumber = " -> " . $row['part_number_dp3'];
 			else {
 				$partNumber = "";
 			}
			$rowcount++;
		}
		$fileName = "Exported_".$type."_".$filenameDate.".xls";
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'.$fileName.'"');
		header('Cache-Control: max-age=0');
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		$objWriter->save('php://output');
}

export_excel_csv();
?>
