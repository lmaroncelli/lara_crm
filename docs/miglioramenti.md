# fatturazione


- al momento di cercare i servizi NON fatturati di un cliente per renderli fruibili all'interno di una fattura, al momento li scrivo come campo testuale all'interno della descrizione della riga di fatturazione. Se per ogni servizio avessi anche il prezzo potrei inserire ogni servizio come riga di fatturazione indipendente in moda d aprecompilare la fattura






#PROBLEMI


le fatture sembrano avere data differente
es: id = 16453

sul DB date_format(from_unixtime(`f`.`data`),'%d/%m/%Y') AS `data_fattura` 04/10/2018
quando le ho importate con FattureTableSeeder Carbon::createFromTimestamp($fattura['data'])->toDateString() 2018-10-03

basta settare in config/app.php 

 'timezone' => 'Europe/Rome',