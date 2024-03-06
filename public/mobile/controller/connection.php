<?php
  $conn = new mysqli("localhost", "thesisapp_U51mt4db", "mko0(*UHBvgy7", "thesisapp_51mt4db");
  
  if ($conn->connect_error){
    die("Koneksi Gagal: " . $conn->connect_error);
  }
?>