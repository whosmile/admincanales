--------------------------------------------------------
-- Archivo creado  - miércoles-diciembre-11-2024   
--------------------------------------------------------
--------------------------------------------------------
--  DDL for Table TB_PARAMETERS
--------------------------------------------------------

  CREATE TABLE "DSHB"."TB_PARAMETERS" 
   (	"ID" NUMBER(10,0), 
	"CODIGO" VARCHAR2(191 BYTE), 
	"NOMBRE" VARCHAR2(191 BYTE), 
	"VALOR" VARCHAR2(191 BYTE), 
	"CREATED_AT" TIMESTAMP (6) DEFAULT NULL, 
	"UPDATED_AT" TIMESTAMP (6) DEFAULT NULL
   ) SEGMENT CREATION IMMEDIATE 
  PCTFREE 10 PCTUSED 40 INITRANS 1 MAXTRANS 255 
 NOCOMPRESS LOGGING
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1
  BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "DSHB_DATA" ;

   COMMENT ON COLUMN "DSHB"."TB_PARAMETERS"."ID" IS 'Código Auto-numérico';
   COMMENT ON COLUMN "DSHB"."TB_PARAMETERS"."CODIGO" IS 'Código del parámetro';
   COMMENT ON COLUMN "DSHB"."TB_PARAMETERS"."NOMBRE" IS 'Nombre del parámetro';
   COMMENT ON COLUMN "DSHB"."TB_PARAMETERS"."VALOR" IS 'Valor del parámetro';
   COMMENT ON COLUMN "DSHB"."TB_PARAMETERS"."CREATED_AT" IS 'Fecha de creación';
   COMMENT ON COLUMN "DSHB"."TB_PARAMETERS"."UPDATED_AT" IS 'Fecha de actualización';
REM INSERTING into DSHB.TB_PARAMETERS
SET DEFINE OFF;
Insert into DSHB.TB_PARAMETERS (ID,CODIGO,NOMBRE,VALOR,CREATED_AT,UPDATED_AT) values ('97','simpletv.pago.min','Monto mínimo pago SimpleTv','15',to_timestamp('20/02/24 03:27:34,000000000 PM','DD/MM/RR HH12:MI:SSXFF AM'),to_timestamp('20/02/24 03:27:34,000000000 PM','DD/MM/RR HH12:MI:SSXFF AM'));
Insert into DSHB.TB_PARAMETERS (ID,CODIGO,NOMBRE,VALOR,CREATED_AT,UPDATED_AT) values ('98','simpletv.pago.max','Monto máximo pago SimpleTv','5900',to_timestamp('20/02/24 03:27:34,000000000 PM','DD/MM/RR HH12:MI:SSXFF AM'),to_timestamp('20/02/24 03:27:34,000000000 PM','DD/MM/RR HH12:MI:SSXFF AM'));
Insert into DSHB.TB_PARAMETERS (ID,CODIGO,NOMBRE,VALOR,CREATED_AT,UPDATED_AT) values ('116','max.pagotransferencias.especial.j','Meximo de transferencias para clientes tipo ESPECIAL','1600000',null,null);
Insert into DSHB.TB_PARAMETERS (ID,CODIGO,NOMBRE,VALOR,CREATED_AT,UPDATED_AT) values ('75','seguridad.resp.desaf.min','Minino caracteres requerido para las respuestas de desafío','4',to_timestamp('25/04/23 05:00:00,199000000 PM','DD/MM/RR HH12:MI:SSXFF AM'),to_timestamp('25/04/23 05:00:00,906000000 PM','DD/MM/RR HH12:MI:SSXFF AM'));
Insert into DSHB.TB_PARAMETERS (ID,CODIGO,NOMBRE,VALOR,CREATED_AT,UPDATED_AT) values ('74','vencimiento.sesion.login','Tiempo máximo de vencimiento de sesión en el login','7',to_timestamp('15/08/23 05:00:00,199000000 PM','DD/MM/RR HH12:MI:SSXFF AM'),to_timestamp('15/08/23 05:00:00,199000000 PM','DD/MM/RR HH12:MI:SSXFF AM'));
Insert into DSHB.TB_PARAMETERS (ID,CODIGO,NOMBRE,VALOR,CREATED_AT,UPDATED_AT) values ('1','transferencias.internas.propias.max','Monto maximo de transferencias internas a cuentas propias','-1',to_timestamp('01/04/20 11:00:00,000000000 PM','DD/MM/RR HH12:MI:SSXFF AM'),to_timestamp('01/04/20 11:00:00,000000000 PM','DD/MM/RR HH12:MI:SSXFF AM'));
Insert into DSHB.TB_PARAMETERS (ID,CODIGO,NOMBRE,VALOR,CREATED_AT,UPDATED_AT) values ('2','transferencias.internas.propias.min','Monto minimo de transferencias internas a cuentas propias','0,01',to_timestamp('01/04/20 11:00:00,000000000 PM','DD/MM/RR HH12:MI:SSXFF AM'),to_timestamp('01/04/20 11:00:00,000000000 PM','DD/MM/RR HH12:MI:SSXFF AM'));
Insert into DSHB.TB_PARAMETERS (ID,CODIGO,NOMBRE,VALOR,CREATED_AT,UPDATED_AT) values ('3','transferencias.internas.tercero.min','Monto mÃ­nimo de transferencias internas a cuentas terceros','0.01',to_timestamp('01/04/20 11:00:00,000000000 PM','DD/MM/RR HH12:MI:SSXFF AM'),to_timestamp('01/04/20 11:00:00,000000000 PM','DD/MM/RR HH12:MI:SSXFF AM'));
Insert into DSHB.TB_PARAMETERS (ID,CODIGO,NOMBRE,VALOR,CREATED_AT,UPDATED_AT) values ('4','transferencias.internas.tercero.max','Monto mÃ¡ximo de transferencias internas a cuentas terceros','-1',to_timestamp('01/04/20 11:00:00,000000000 PM','DD/MM/RR HH12:MI:SSXFF AM'),to_timestamp('01/04/20 11:00:00,000000000 PM','DD/MM/RR HH12:MI:SSXFF AM'));
Insert into DSHB.TB_PARAMETERS (ID,CODIGO,NOMBRE,VALOR,CREATED_AT,UPDATED_AT) values ('5','pagos.internas.propias.max','Monto mÃ¡ximo de pagos internas a cuentas propias','-1',to_timestamp('01/04/20 11:00:00,000000000 PM','DD/MM/RR HH12:MI:SSXFF AM'),to_timestamp('13/11/24 12:00:00,000000000 AM','DD/MM/RR HH12:MI:SSXFF AM'));
Insert into DSHB.TB_PARAMETERS (ID,CODIGO,NOMBRE,VALOR,CREATED_AT,UPDATED_AT) values ('6','pagos.internas.propias.min','Monto mÃ­nimo de pagos internas a cuentas propias','0.01',to_timestamp('01/04/20 11:00:00,000000000 PM','DD/MM/RR HH12:MI:SSXFF AM'),to_timestamp('01/04/20 11:00:00,000000000 PM','DD/MM/RR HH12:MI:SSXFF AM'));
Insert into DSHB.TB_PARAMETERS (ID,CODIGO,NOMBRE,VALOR,CREATED_AT,UPDATED_AT) values ('7','pagos.internas.tercero.min','Monto mÃ­nimo de pagos internas a cuentas terceros','0.01',to_timestamp('01/04/20 11:00:00,000000000 PM','DD/MM/RR HH12:MI:SSXFF AM'),to_timestamp('01/04/20 11:00:00,000000000 PM','DD/MM/RR HH12:MI:SSXFF AM'));
Insert into DSHB.TB_PARAMETERS (ID,CODIGO,NOMBRE,VALOR,CREATED_AT,UPDATED_AT) values ('8','pagos.internas.tercero.max','Monto mÃ¡ximo de pagos internas a cuentas terceros','-1',to_timestamp('01/04/20 11:00:00,000000000 PM','DD/MM/RR HH12:MI:SSXFF AM'),to_timestamp('01/04/20 11:00:00,000000000 PM','DD/MM/RR HH12:MI:SSXFF AM'));
Insert into DSHB.TB_PARAMETERS (ID,CODIGO,NOMBRE,VALOR,CREATED_AT,UPDATED_AT) values ('9','dias.vencimiento.claves.all','Cantidad de dias para el vencimiento de la clave (ingreso y operaciones especiales)','180',to_timestamp('01/04/20 11:00:00,000000000 PM','DD/MM/RR HH12:MI:SSXFF AM'),to_timestamp('01/04/20 11:00:00,000000000 PM','DD/MM/RR HH12:MI:SSXFF AM'));
Insert into DSHB.TB_PARAMETERS (ID,CODIGO,NOMBRE,VALOR,CREATED_AT,UPDATED_AT) values ('10','pagomovil.max','Monto maximo de sistema de pago movil interbancario','30000',to_timestamp('01/04/20 11:00:00,000000000 PM','DD/MM/RR HH12:MI:SSXFF AM'),to_timestamp('07/06/23 12:00:00,000000000 AM','DD/MM/RR HH12:MI:SSXFF AM'));
Insert into DSHB.TB_PARAMETERS (ID,CODIGO,NOMBRE,VALOR,CREATED_AT,UPDATED_AT) values ('11','pagomovil.min','Monto mÃ­nimo de sistema de pago movil interbancario','0.01',to_timestamp('01/04/20 11:00:00,000000000 PM','DD/MM/RR HH12:MI:SSXFF AM'),to_timestamp('01/04/20 11:00:00,000000000 PM','DD/MM/RR HH12:MI:SSXFF AM'));
Insert into DSHB.TB_PARAMETERS (ID,CODIGO,NOMBRE,VALOR,CREATED_AT,UPDATED_AT) values ('12','transferencias.externas.terceros.max','Monto mÃ¡ximo de transferencias externas a cuentas de terceros','50000',to_timestamp('01/04/20 11:00:00,000000000 PM','DD/MM/RR HH12:MI:SSXFF AM'),to_timestamp('07/06/23 12:00:00,000000000 AM','DD/MM/RR HH12:MI:SSXFF AM'));
Insert into DSHB.TB_PARAMETERS (ID,CODIGO,NOMBRE,VALOR,CREATED_AT,UPDATED_AT) values ('13','transferencias.externas.terceros.min','Monto mÃ­nimo de transferencias externas a cuentas de terceros','0.01',to_timestamp('01/04/20 11:00:00,000000000 PM','DD/MM/RR HH12:MI:SSXFF AM'),to_timestamp('01/04/20 11:00:00,000000000 PM','DD/MM/RR HH12:MI:SSXFF AM'));
Insert into DSHB.TB_PARAMETERS (ID,CODIGO,NOMBRE,VALOR,CREATED_AT,UPDATED_AT) values ('15','pagos.externas.terceros.max','Monto mÃ¡ximo de pagos de TDC a terceros ','50000',to_timestamp('01/04/20 11:00:00,000000000 PM','DD/MM/RR HH12:MI:SSXFF AM'),to_timestamp('07/06/23 12:00:00,000000000 AM','DD/MM/RR HH12:MI:SSXFF AM'));
Insert into DSHB.TB_PARAMETERS (ID,CODIGO,NOMBRE,VALOR,CREATED_AT,UPDATED_AT) values ('16','pagos.externas.terceros.min','Monto mÃ­nimo de pagos de TDC a terceros','0.01',to_timestamp('01/04/20 11:00:00,000000000 PM','DD/MM/RR HH12:MI:SSXFF AM'),to_timestamp('01/04/20 11:00:00,000000000 PM','DD/MM/RR HH12:MI:SSXFF AM'));
Insert into DSHB.TB_PARAMETERS (ID,CODIGO,NOMBRE,VALOR,CREATED_AT,UPDATED_AT) values ('17','seguridad.clave.longitud.min','Longitud minima de claves','8',to_timestamp('01/04/20 11:00:00,000000000 PM','DD/MM/RR HH12:MI:SSXFF AM'),to_timestamp('01/04/20 11:00:00,000000000 PM','DD/MM/RR HH12:MI:SSXFF AM'));
Insert into DSHB.TB_PARAMETERS (ID,CODIGO,NOMBRE,VALOR,CREATED_AT,UPDATED_AT) values ('18','seguridad.clave.longitud.max','Longitud maxima de claves','16',to_timestamp('01/04/20 11:00:00,000000000 PM','DD/MM/RR HH12:MI:SSXFF AM'),to_timestamp('01/04/20 11:00:00,000000000 PM','DD/MM/RR HH12:MI:SSXFF AM'));
Insert into DSHB.TB_PARAMETERS (ID,CODIGO,NOMBRE,VALOR,CREATED_AT,UPDATED_AT) values ('29','transferencias.externas.comision','Monto de la comision de las transferencias externas','0,30',to_timestamp('01/04/20 11:00:00,000000000 PM','DD/MM/RR HH12:MI:SSXFF AM'),to_timestamp('01/09/22 12:00:00,000000000 AM','DD/MM/RR HH12:MI:SSXFF AM'));
Insert into DSHB.TB_PARAMETERS (ID,CODIGO,NOMBRE,VALOR,CREATED_AT,UPDATED_AT) values ('33','max.pagotransferencias.internas.n','max.pagotransferencias.internas.n','-1',to_timestamp('01/04/20 11:00:00,000000000 PM','DD/MM/RR HH12:MI:SSXFF AM'),to_timestamp('01/04/20 11:00:00,000000000 PM','DD/MM/RR HH12:MI:SSXFF AM'));
Insert into DSHB.TB_PARAMETERS (ID,CODIGO,NOMBRE,VALOR,CREATED_AT,UPDATED_AT) values ('34','max.pagotransferencias.externas.n','max.pagotransferencias.externas.n','50000',to_timestamp('01/04/20 11:00:00,000000000 PM','DD/MM/RR HH12:MI:SSXFF AM'),to_timestamp('07/06/23 12:00:00,000000000 AM','DD/MM/RR HH12:MI:SSXFF AM'));
Insert into DSHB.TB_PARAMETERS (ID,CODIGO,NOMBRE,VALOR,CREATED_AT,UPDATED_AT) values ('35','max.pagotransferencias.internas.j','max.pagotransferencias.externas.n','-1',to_timestamp('01/04/20 11:00:00,000000000 PM','DD/MM/RR HH12:MI:SSXFF AM'),to_timestamp('01/04/20 11:00:00,000000000 PM','DD/MM/RR HH12:MI:SSXFF AM'));
Insert into DSHB.TB_PARAMETERS (ID,CODIGO,NOMBRE,VALOR,CREATED_AT,UPDATED_AT) values ('36','max.pagotransferencias.externas.j','max.pagotransferencias.externas.j','150000',to_timestamp('01/04/20 11:00:00,000000000 PM','DD/MM/RR HH12:MI:SSXFF AM'),to_timestamp('07/06/23 12:00:00,000000000 AM','DD/MM/RR HH12:MI:SSXFF AM'));
Insert into DSHB.TB_PARAMETERS (ID,CODIGO,NOMBRE,VALOR,CREATED_AT,UPDATED_AT) values ('37','min.pagotransferencias.internas','min.pagotransferencias.internas','0.01',to_timestamp('01/04/20 11:00:00,000000000 PM','DD/MM/RR HH12:MI:SSXFF AM'),to_timestamp('01/04/20 11:00:00,000000000 PM','DD/MM/RR HH12:MI:SSXFF AM'));
Insert into DSHB.TB_PARAMETERS (ID,CODIGO,NOMBRE,VALOR,CREATED_AT,UPDATED_AT) values ('38','min.pagotransferencias.externas','min.pagotransferencias.externas','0.01',to_timestamp('01/04/20 11:00:00,000000000 PM','DD/MM/RR HH12:MI:SSXFF AM'),to_timestamp('01/04/20 11:00:00,000000000 PM','DD/MM/RR HH12:MI:SSXFF AM'));
Insert into DSHB.TB_PARAMETERS (ID,CODIGO,NOMBRE,VALOR,CREATED_AT,UPDATED_AT) values ('39','boton.registro','Activacion del boton de registro','1',to_timestamp('01/04/20 11:00:00,000000000 PM','DD/MM/RR HH12:MI:SSXFF AM'),to_timestamp('01/04/20 11:00:00,000000000 PM','DD/MM/RR HH12:MI:SSXFF AM'));
Insert into DSHB.TB_PARAMETERS (ID,CODIGO,NOMBRE,VALOR,CREATED_AT,UPDATED_AT) values ('40','transferencias.externas.comision.altovalor','transferencias.externas.comision.altovalor','8,15',to_timestamp('01/04/20 11:00:00,000000000 PM','DD/MM/RR HH12:MI:SSXFF AM'),to_timestamp('19/12/22 12:00:00,000000000 AM','DD/MM/RR HH12:MI:SSXFF AM'));
Insert into DSHB.TB_PARAMETERS (ID,CODIGO,NOMBRE,VALOR,CREATED_AT,UPDATED_AT) values ('41','transferencias.externas.comision.altovalor_limite','transferencias.externas.comision.altovalor_limite','8,15',to_timestamp('01/04/20 11:00:00,000000000 PM','DD/MM/RR HH12:MI:SSXFF AM'),to_timestamp('19/12/22 12:00:00,000000000 AM','DD/MM/RR HH12:MI:SSXFF AM'));
Insert into DSHB.TB_PARAMETERS (ID,CODIGO,NOMBRE,VALOR,CREATED_AT,UPDATED_AT) values ('42','max.cantidad.transferencias.multiples.n','max.transferencias.multiples.n','-1',to_timestamp('01/04/20 11:00:00,000000000 PM','DD/MM/RR HH12:MI:SSXFF AM'),to_timestamp('21/12/22 12:00:00,000000000 AM','DD/MM/RR HH12:MI:SSXFF AM'));
Insert into DSHB.TB_PARAMETERS (ID,CODIGO,NOMBRE,VALOR,CREATED_AT,UPDATED_AT) values ('43','max.cantidad.transferencias.multiples.j','max.transferencias.multiples.j','-1',to_timestamp('01/04/20 11:00:00,000000000 PM','DD/MM/RR HH12:MI:SSXFF AM'),to_timestamp('21/12/22 12:00:00,000000000 AM','DD/MM/RR HH12:MI:SSXFF AM'));
Insert into DSHB.TB_PARAMETERS (ID,CODIGO,NOMBRE,VALOR,CREATED_AT,UPDATED_AT) values ('44','referencias.firmante.nombre','Nombre del firmante en las referencias bancarias ','Mirvida Prieto',to_timestamp('01/04/20 11:00:00,000000000 PM','DD/MM/RR HH12:MI:SSXFF AM'),to_timestamp('03/04/23 12:00:00,000000000 AM','DD/MM/RR HH12:MI:SSXFF AM'));
Insert into DSHB.TB_PARAMETERS (ID,CODIGO,NOMBRE,VALOR,CREATED_AT,UPDATED_AT) values ('45','referencias.firmante.cargo','Nombre del cargo del firmante en las referncias bancarias ','VP. Red de Agencias',to_timestamp('01/04/20 11:00:00,000000000 PM','DD/MM/RR HH12:MI:SSXFF AM'),to_timestamp('01/04/20 11:00:00,000000000 PM','DD/MM/RR HH12:MI:SSXFF AM'));
Insert into DSHB.TB_PARAMETERS (ID,CODIGO,NOMBRE,VALOR,CREATED_AT,UPDATED_AT) values ('46','referencias.firmante.imagen','Imagen de la firma, que va en la referencia bancaria ','mirvidaprieto.jpg',to_timestamp('01/04/20 11:00:00,000000000 PM','DD/MM/RR HH12:MI:SSXFF AM'),to_timestamp('04/04/23 12:00:00,000000000 AM','DD/MM/RR HH12:MI:SSXFF AM'));
Insert into DSHB.TB_PARAMETERS (ID,CODIGO,NOMBRE,VALOR,CREATED_AT,UPDATED_AT) values ('47','convenio.nomina','CÃ³digo de convenio para efectuar pagos masivos en la nomina','009',to_timestamp('01/04/20 11:00:00,000000000 PM','DD/MM/RR HH12:MI:SSXFF AM'),to_timestamp('01/04/20 11:00:00,000000000 PM','DD/MM/RR HH12:MI:SSXFF AM'));
Insert into DSHB.TB_PARAMETERS (ID,CODIGO,NOMBRE,VALOR,CREATED_AT,UPDATED_AT) values ('48','convenio.proveedores','CÃ³digo de convenio para efectuar pagos masivos en proveedores','010',to_timestamp('01/04/20 11:00:00,000000000 PM','DD/MM/RR HH12:MI:SSXFF AM'),to_timestamp('01/04/20 11:00:00,000000000 PM','DD/MM/RR HH12:MI:SSXFF AM'));
Insert into DSHB.TB_PARAMETERS (ID,CODIGO,NOMBRE,VALOR,CREATED_AT,UPDATED_AT) values ('50','mantenimiento.flag','Activa o desactiva la imagen de mantenimiento','0',to_timestamp('01/04/20 11:00:00,000000000 PM','DD/MM/RR HH12:MI:SSXFF AM'),to_timestamp('01/04/20 11:00:00,000000000 PM','DD/MM/RR HH12:MI:SSXFF AM'));
Insert into DSHB.TB_PARAMETERS (ID,CODIGO,NOMBRE,VALOR,CREATED_AT,UPDATED_AT) values ('51','mantenimiento.img','Imagen, mostrada en caso de estar en mantenimiento','https://online.delsur.com.ve/img/bg/ENMANTENIMIENTO-NORMAL.jpg',to_timestamp('01/04/20 11:00:00,000000000 PM','DD/MM/RR HH12:MI:SSXFF AM'),to_timestamp('01/04/20 11:00:00,000000000 PM','DD/MM/RR HH12:MI:SSXFF AM'));
Insert into DSHB.TB_PARAMETERS (ID,CODIGO,NOMBRE,VALOR,CREATED_AT,UPDATED_AT) values ('54','banner.index','Banner informativo para la posicion global','https://online.delsur.com.ve/img/banners/003.gif',to_timestamp('01/04/20 11:00:00,000000000 PM','DD/MM/RR HH12:MI:SSXFF AM'),to_timestamp('01/04/20 11:00:00,000000000 PM','DD/MM/RR HH12:MI:SSXFF AM'));
Insert into DSHB.TB_PARAMETERS (ID,CODIGO,NOMBRE,VALOR,CREATED_AT,UPDATED_AT) values ('55','banner.flag','Activa o desactiva la imagen de banner','1',to_timestamp('01/04/20 11:00:00,000000000 PM','DD/MM/RR HH12:MI:SSXFF AM'),to_timestamp('01/04/20 11:00:00,000000000 PM','DD/MM/RR HH12:MI:SSXFF AM'));
Insert into DSHB.TB_PARAMETERS (ID,CODIGO,NOMBRE,VALOR,CREATED_AT,UPDATED_AT) values ('56','min.pago.nomina.externas','Monto minimo para el pago masivo de nomina a otros bancos','0,01',to_timestamp('01/04/20 11:00:00,000000000 PM','DD/MM/RR HH12:MI:SSXFF AM'),to_timestamp('01/04/20 11:00:00,000000000 PM','DD/MM/RR HH12:MI:SSXFF AM'));
Insert into DSHB.TB_PARAMETERS (ID,CODIGO,NOMBRE,VALOR,CREATED_AT,UPDATED_AT) values ('57','max.pago.nomina.externas','Monto maximo para el pago masivo de nomina a otros bancos','150000',to_timestamp('01/04/20 11:00:00,000000000 PM','DD/MM/RR HH12:MI:SSXFF AM'),to_timestamp('07/06/23 12:00:00,000000000 AM','DD/MM/RR HH12:MI:SSXFF AM'));
Insert into DSHB.TB_PARAMETERS (ID,CODIGO,NOMBRE,VALOR,CREATED_AT,UPDATED_AT) values ('58','min.pago.proveedores.externas','Monto minimo para el pago masivo de proveedores a otros bancos','0,01',to_timestamp('01/04/20 11:00:00,000000000 PM','DD/MM/RR HH12:MI:SSXFF AM'),to_timestamp('01/04/20 11:00:00,000000000 PM','DD/MM/RR HH12:MI:SSXFF AM'));
Insert into DSHB.TB_PARAMETERS (ID,CODIGO,NOMBRE,VALOR,CREATED_AT,UPDATED_AT) values ('59','max.pago.proveedores.externas','Monto maximo para el pago masivo de proveedores a otros bancos','500000',to_timestamp('01/04/20 11:00:00,000000000 PM','DD/MM/RR HH12:MI:SSXFF AM'),to_timestamp('13/11/24 12:00:00,000000000 AM','DD/MM/RR HH12:MI:SSXFF AM'));
Insert into DSHB.TB_PARAMETERS (ID,CODIGO,NOMBRE,VALOR,CREATED_AT,UPDATED_AT) values ('60','petro.bolivares.monto','Monto en bolivares equivalencia petro','1415,23',to_timestamp('01/04/20 11:00:00,000000000 PM','DD/MM/RR HH12:MI:SSXFF AM'),to_timestamp('08/02/23 12:00:00,000000000 AM','DD/MM/RR HH12:MI:SSXFF AM'));
Insert into DSHB.TB_PARAMETERS (ID,CODIGO,NOMBRE,VALOR,CREATED_AT,UPDATED_AT) values ('61','petro.dolares.monto','Monto en dolares equivalencia petro','60',to_timestamp('01/04/20 11:00:00,000000000 PM','DD/MM/RR HH12:MI:SSXFF AM'),to_timestamp('01/04/20 11:00:00,000000000 PM','DD/MM/RR HH12:MI:SSXFF AM'));
Insert into DSHB.TB_PARAMETERS (ID,CODIGO,NOMBRE,VALOR,CREATED_AT,UPDATED_AT) values ('62','limite.plazo.ausencia','Indica el limite en dias para el plazo de ausencias','180',to_timestamp('01/04/20 11:00:00,000000000 PM','DD/MM/RR HH12:MI:SSXFF AM'),to_timestamp('01/04/20 11:00:00,000000000 PM','DD/MM/RR HH12:MI:SSXFF AM'));
Insert into DSHB.TB_PARAMETERS (ID,CODIGO,NOMBRE,VALOR,CREATED_AT,UPDATED_AT) values ('63','limite.ubicacion.seguridad','Indica el limite de notificaciones que puede reportar el cliente','2',to_timestamp('01/04/20 11:00:00,000000000 PM','DD/MM/RR HH12:MI:SSXFF AM'),to_timestamp('01/04/20 11:00:00,000000000 PM','DD/MM/RR HH12:MI:SSXFF AM'));
Insert into DSHB.TB_PARAMETERS (ID,CODIGO,NOMBRE,VALOR,CREATED_AT,UPDATED_AT) values ('64','buzon.correo.alertas','Buzon de correo para el envio de alertas al area de monitoreo','delsuronline@delsur.com.ve',to_timestamp('01/04/20 11:00:00,000000000 PM','DD/MM/RR HH12:MI:SSXFF AM'),to_timestamp('01/04/20 11:00:00,000000000 PM','DD/MM/RR HH12:MI:SSXFF AM'));
Insert into DSHB.TB_PARAMETERS (ID,CODIGO,NOMBRE,VALOR,CREATED_AT,UPDATED_AT) values ('65','seguridad.usuario.longitud.min','Longitud minima de usuario','8',to_timestamp('01/04/20 11:00:00,000000000 PM','DD/MM/RR HH12:MI:SSXFF AM'),to_timestamp('01/04/20 11:00:00,000000000 PM','DD/MM/RR HH12:MI:SSXFF AM'));
Insert into DSHB.TB_PARAMETERS (ID,CODIGO,NOMBRE,VALOR,CREATED_AT,UPDATED_AT) values ('66','seguridad.usuario.longitud.max','Longitud maxima de usuario','12',to_timestamp('01/04/20 11:00:00,000000000 PM','DD/MM/RR HH12:MI:SSXFF AM'),to_timestamp('01/04/20 11:00:00,000000000 PM','DD/MM/RR HH12:MI:SSXFF AM'));
Insert into DSHB.TB_PARAMETERS (ID,CODIGO,NOMBRE,VALOR,CREATED_AT,UPDATED_AT) values ('67','horario.compensacion.desde','Horario de la camara de compensacion electronica ejecucion','9:00 AM',to_timestamp('01/04/20 11:00:00,000000000 PM','DD/MM/RR HH12:MI:SSXFF AM'),to_timestamp('01/04/20 11:00:00,000000000 PM','DD/MM/RR HH12:MI:SSXFF AM'));
Insert into DSHB.TB_PARAMETERS (ID,CODIGO,NOMBRE,VALOR,CREATED_AT,UPDATED_AT) values ('68','horario.compensacion.hasta','Horario de la camara de compensacion electronica acredita','9:00 AM',to_timestamp('01/04/20 11:00:00,000000000 PM','DD/MM/RR HH12:MI:SSXFF AM'),to_timestamp('01/04/20 11:00:00,000000000 PM','DD/MM/RR HH12:MI:SSXFF AM'));
Insert into DSHB.TB_PARAMETERS (ID,CODIGO,NOMBRE,VALOR,CREATED_AT,UPDATED_AT) values ('69','activacion.ip','Indica si esta activa la validacion de IP en la Web','0',to_timestamp('01/04/20 11:00:00,000000000 PM','DD/MM/RR HH12:MI:SSXFF AM'),to_timestamp('01/04/20 11:00:00,000000000 PM','DD/MM/RR HH12:MI:SSXFF AM'));
Insert into DSHB.TB_PARAMETERS (ID,CODIGO,NOMBRE,VALOR,CREATED_AT,UPDATED_AT) values ('70','vencimiento.clave.dinamica','Cantidad de minutos para el vencimiento de la clave dinamica','10',to_timestamp('01/04/20 11:00:00,000000000 PM','DD/MM/RR HH12:MI:SSXFF AM'),to_timestamp('01/04/20 11:00:00,000000000 PM','DD/MM/RR HH12:MI:SSXFF AM'));
Insert into DSHB.TB_PARAMETERS (ID,CODIGO,NOMBRE,VALOR,CREATED_AT,UPDATED_AT) values ('71','vencimiento.preguntas.desafio','Cantidad de dias para el vencimiento de las preguntas de desafio','180',to_timestamp('01/04/20 11:00:00,000000000 PM','DD/MM/RR HH12:MI:SSXFF AM'),to_timestamp('01/04/20 11:00:00,000000000 PM','DD/MM/RR HH12:MI:SSXFF AM'));
Insert into DSHB.TB_PARAMETERS (ID,CODIGO,NOMBRE,VALOR,CREATED_AT,UPDATED_AT) values ('72','vencimiento.imagen.oesp','Cantidad de dias para el vencimiento de la imagen de operaciones especiales','180',to_timestamp('01/04/20 11:00:00,000000000 PM','DD/MM/RR HH12:MI:SSXFF AM'),to_timestamp('01/04/20 11:00:00,000000000 PM','DD/MM/RR HH12:MI:SSXFF AM'));
Insert into DSHB.TB_PARAMETERS (ID,CODIGO,NOMBRE,VALOR,CREATED_AT,UPDATED_AT) values ('73','petro.euros.monto','Monto en euros equivalencia Petro','50',to_timestamp('01/04/20 11:00:00,000000000 PM','DD/MM/RR HH12:MI:SSXFF AM'),to_timestamp('01/04/20 11:00:00,000000000 PM','DD/MM/RR HH12:MI:SSXFF AM'));
Insert into DSHB.TB_PARAMETERS (ID,CODIGO,NOMBRE,VALOR,CREATED_AT,UPDATED_AT) values ('117','horario.pagoservicio.desde','Horario de pago de servicios sin servicio','10:00 PM',null,null);
Insert into DSHB.TB_PARAMETERS (ID,CODIGO,NOMBRE,VALOR,CREATED_AT,UPDATED_AT) values ('118','horario.pagoservicio.hasta','Horario de pago de servicios con servicio','12:00 PM',null,null);
Insert into DSHB.TB_PARAMETERS (ID,CODIGO,NOMBRE,VALOR,CREATED_AT,UPDATED_AT) values ('136','suiche.transaccion','Suiche para cambiar entre los pagos P2P y TTOB, siendo exlusivos uno del otro, los valores son: TTOB o P2P','TTOB',to_timestamp('03/09/24 11:40:34,000000000 AM','DD/MM/RR HH12:MI:SSXFF AM'),to_timestamp('03/09/24 11:40:34,000000000 AM','DD/MM/RR HH12:MI:SSXFF AM'));
Insert into DSHB.TB_PARAMETERS (ID,CODIGO,NOMBRE,VALOR,CREATED_AT,UPDATED_AT) values ('137','suiche.transaccion.timeout','Tiempo de timeout específico para la ejecución de TTOB durante la ejecución de un pago móvil','15',to_timestamp('03/09/24 11:40:34,000000000 AM','DD/MM/RR HH12:MI:SSXFF AM'),to_timestamp('03/09/24 11:40:34,000000000 AM','DD/MM/RR HH12:MI:SSXFF AM'));
Insert into DSHB.TB_PARAMETERS (ID,CODIGO,NOMBRE,VALOR,CREATED_AT,UPDATED_AT) values ('156','suiche.canal.notificacion','Suiche que funciona para cambiar el canal del envó de la clave dinámica por correo o sms, sus valores son: SMS o MAIL','MAIL',to_timestamp('11/09/24 02:06:34,000000000 PM','DD/MM/RR HH12:MI:SSXFF AM'),to_timestamp('11/09/24 02:06:34,000000000 PM','DD/MM/RR HH12:MI:SSXFF AM'));
--------------------------------------------------------
--  DDL for Index SYS_C005608
--------------------------------------------------------

  CREATE UNIQUE INDEX "DSHB"."SYS_C005608" ON "DSHB"."TB_PARAMETERS" ("ID") 
  PCTFREE 10 INITRANS 2 MAXTRANS 255 COMPUTE STATISTICS 
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1
  BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "DSHB_INDEX" ;
--------------------------------------------------------
--  Constraints for Table TB_PARAMETERS
--------------------------------------------------------

  ALTER TABLE "DSHB"."TB_PARAMETERS" ADD PRIMARY KEY ("ID")
  USING INDEX PCTFREE 10 INITRANS 2 MAXTRANS 255 COMPUTE STATISTICS 
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1
  BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "DSHB_INDEX"  ENABLE;
  ALTER TABLE "DSHB"."TB_PARAMETERS" ADD CONSTRAINT "PARAM_UNUM_ID" CHECK (id between 0 and 4294967295) ENABLE;
  ALTER TABLE "DSHB"."TB_PARAMETERS" MODIFY ("VALOR" NOT NULL ENABLE);
  ALTER TABLE "DSHB"."TB_PARAMETERS" MODIFY ("CODIGO" NOT NULL ENABLE);
  ALTER TABLE "DSHB"."TB_PARAMETERS" MODIFY ("ID" NOT NULL ENABLE);
--------------------------------------------------------
--  DDL for Trigger TG_IDPARAM
--------------------------------------------------------

  CREATE OR REPLACE TRIGGER "DSHB"."TG_IDPARAM" 
BEFORE INSERT ON tb_parameters
FOR EACH ROW
   WHEN (new.ID IS NULL) BEGIN
  :new.ID := sec_idparam.NEXTVAL;
END;

/
ALTER TRIGGER "DSHB"."TG_IDPARAM" ENABLE;
