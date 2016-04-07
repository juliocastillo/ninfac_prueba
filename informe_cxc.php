<?
session_start();
$_SESSION['login'];
extract($_GET);
if ($_SESSION['login']!=true){
    echo "<script>window.location = './login.php'</script>";
} 

//archivos comunes *********************************
include_once ('./common.html');
include ("./conexion.php");
require_once('./menuprincipal.php');
//**************************************************
include ("./llenarlistas.php");
include ("./tools.php");
include ("./model.php");
include_once ('./common.html');
extract($_GET);
datevalidsp();
$model=new Model();
$db=new MySQL();
?>

<html>
    <head>
        <title>Ninfac</title>
        <!--creado por Julio Castillo, septiembre de 2013-->
        <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
        <link rel="stylesheet" href="" type="text/css">
       
    </head>
    <body class="PageBODY"><form action="" method="get" name="buscar" style="background-color: white">
    <center>
    <div style="border: 1px seagreen solid;  border-radius: 1px; width: 600px; position: relative;">
    <table style="width:100%">
        <tr>
        <td colspan="4" align="center" style="border: 1px gainsboro outset; background: gainsboro">
            <font class="FormHeaderFONT">Informes de cuentas por cobrar</font>
        </td>
        </tr>
        <tr >
            <td class="" align="right">
                <font class="ColumnFONT"><b>Fecha: desde </b></font>
            </td>
            <td colspan="2" align="left" class="">
                <input type="text" name="finicio" value="<?php echo $finicio; ?>" id="finicio" size="10" maxlength="10" tabindex="6" onBlur="formatofecha(this.id, this.value); date_system_valid(this.id)" onkeyup="mascara(this,'/',patron,true)"/></input>
                <input type="button" value="..." id="finicio_btn" tabindex="7" ></input>
            </td>
            <td colspan="2" align="left" class="">
				<b>Hasta</b>
                <input type="text" name="ffin" value="<?php echo $ffin; ?>" id="ffin" size="10" maxlength="10" tabindex="6" onBlur="formatofecha(this.id, this.value); date_system_valid(this.id)" onkeyup="mascara(this,'/',patron,true)"/></input>
                <input type="button" value="..." id="ffin_btn" tabindex="7" ></input>
            </td>
            </td>
            <tr>
                <td>Seleccione zona</td>
            </tr>
            <tr>
                <td>
                    <select name="id_zona" id="id_zona">
                        <option value="">[Todas]</option>
                        <?php
                            $cbo = new Htmlzonas();
                            $list = $cbo->llenarlista($id_zona);
                            echo $list;
                        ?>
                    </select>
                </td>
            </tr>            
        </tr>
            <td colspan="4" align="center" class="">
               <br><input type="submit" value="Generar reporte" tabindex="10" /></td>
        </tr>
    </table>
    </div>
</form>
<?        
if ($finicio && $ffin) {
    $consulta = $model->get_informe_cxc(datetosql($finicio),datetosql($ffin),$id_zona);
    ?>
        <br>
<div align="center">
    <table class="FormTABLE" style="border: 1px gainsboro solid; border-collapse: collapse;">
        <tr><td style="border: 1px black solid; padding: 0px 1px 0px 1px">Corr</td>
            <td style="border: 1px black solid; padding: 0px 1px 0px 1px">Fecha de<br>documento</td>
            <td style="border: 1px black solid; padding: 0px 1px 0px 1px">Numero de<br>documento</td>
            <td style="border: 1px black solid; padding: 0px 1px 0px 1px">Nombre del cliente</td>
            <td style="border: 1px black solid; padding: 0px 1px 0px 1px">Venta</td>
            <td style="border: 1px black solid; padding: 0px 1px 0px 1px">IVA</td>
            <td style="border: 1px black solid; padding: 0px 1px 0px 1px">1%</td>
            <td style="border: 1px black solid; padding: 0px 1px 0px 1px">Total</td>
            <td style="border: 1px black solid; padding: 0px 1px 0px 1px" width="75px">Fechas</td>
            <td style="border: 1px black solid; padding: 0px 1px 0px 1px" width="40px">#Rec</td>
            <td style="border: 1px black solid; padding: 0px 1px 0px 1px">Total</td>
                <?php 
                $i=0;
                while ($row = $db->fetch_array($consulta)){
                    $i++;
                    ?>
                    <tr>
                       <td align="right" style="background-color: white;border: 1px black solid; padding: 3px"><font class="ColumnFONT"><?php echo $i; ?></td>
                       <td style="background-color: white; border: 1px black solid;"><? echo $row['fecha_documento']; ?></td>
                       <td align="right" style="background-color: white;border: 1px black solid;"><? echo $row['n_documento']; ?></td>
                       <td style="background-color: white;border: 1px black solid; font-family: arial; font-size: 10px"><? echo $row['nombre_cliente']; ?></td>
                       <td align="right" style="background-color: white;border: 1px black solid;font-weight: normal;"><font class="ColumnFONT"><? echo $row['venta_total']; ?></td>
                       <td style="background-color: white;border: 1px black solid;font-weight: normal;"><font class="ColumnFONT"><? echo $row['iva_retenido']; ?></td>
                       <td style="background-color: white;border: 1px black solid;font-weight: normal;"><font class="ColumnFONT"><? echo $row['1%']; ?></td>
                       <td style="background-color: white;border: 1px black solid;font-weight: normal;"><font class="ColumnFONT"><? ?></td>
                       <td style="background-color: white;border: 1px black solid;font-weight: normal;"><font class="ColumnFONT"><? echo $row['fechas']; ?></td>
                       <td style="background-color: white;border: 1px black solid;font-weight: normal;"><font class="ColumnFONT"><? echo $row['recibos']; ?></td>
                       <td style="background-color: white;border: 1px black solid;font-weight: normal;"><font class="ColumnFONT"><? echo $row['total']; ?></td>
                        <?php
                }
                ?>

        </tr>
    </table>
</div>
<? } ?>
    
</body>
    <script language="Javascript">
    Calendar.setup({
        inputField : "finicio",
        trigger    : "finicio_btn",
        onSelect   : function() { this.hide() },
        showTime   : 12,
        weekNumbers: true,
        //dateFormat : "%Y-%m-%d %I:%M %p"
        dateFormat : "%d/%m/%Y",
        align      : ""
    });
    
    Calendar.setup({
        inputField : "ffin",
        trigger    : "ffin_btn",
        onSelect   : function() { this.hide() },
        showTime   : 12,
        weekNumbers: true,
        //dateFormat : "%Y-%m-%d %I:%M %p"
        dateFormat : "%d/%m/%Y",
        align      : ""
    });

        function popup(URL) {
            myWindow = window.open(URL, '" + "', 'scrollbars=yes, width=600, height=600, top = 50');
        }
    </script>

</html>