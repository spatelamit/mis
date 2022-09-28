<?php 
 
#DATABASE Credentials

// define("DB_HOST", "p:127.0.0.1");
// define("DB_USER", "smppuser");
// define("DB_PASS", "SeCuRe@LocalHost#890");
// define("DB_DB", "smppdb");

// #Rabit MQ Credentials
// define("MQ_HOST", "10.10.1.158");
// define("MQ_USER", "mautic");
// define("MQ_PASS", "Tfy@#92H");
// define("MQ_PORT", 5672);

// // #Rabit MQ Credentials
// define("MQ2_HOST", "10.10.1.158");
// define("MQ2_USER", "mautic");
// define("MQ2_PASS", "Tfy@#92H");
// define("MQ2_PORT", 5672);

#Rabit MQ Credentials
// define("MQ_HOST", "10.10.1.158");
// define("MQ_USER", "mautic");
// define("MQ_PASS", "Tfy@#92H");
// define("MQ_PORT", 5672);

// 10.10.1.10
//mautic
//Tfy@#92H

#All Queues   

// AMQPBOX DOWN >>>
#MT 1
// define("MT1", "skannel.down.receive");
// define("MT1_EX", "skannel.down.receive.ex");

// define("MT1_FAKE", "skannel.down.receive.fake");
// define("MT1_EX_FAKE", "skannel.down.receive.fake.ex");
// // APPL >>

// #MT 2
// define("MT2", "skannel.up.receive");
// define("MT2_EX", "skannel.up.receive.ex");

// // AMQPBOX UP >>>

// #MO 3
// define("MO3", "skannel.up.send");
// define("MO3_EX", "skannel.up.send.ex");

// // APPL >>

// #MO 4
// define("MO4", "skannel.down.send");
// define("MO4_EX", "skannel.down.send.ex");

// define("MO5", "kannel.up.send");
// define("MO5_EX", "kannel.up.send.ex");

// // Bssp ki MO
// define("MO6", "sms.mo.update");
// define("MO6_EX", "sms.mo.update.ex");
// // Bssp ki MO

// // AMQPBOX down >>>

// #DB MT 1
// define("INSERT", "smysql.mt.insert");  
// define("INSERT_EX", "smysql.mt.insert.ex"); 

// #DB MO 2
// define("UPDATE", "smysql.mo.update");
// define("UPDATE_EX", "smysql.mo.update.ex");

 ?>