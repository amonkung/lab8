<?php
    // สำหรับ Hosting ส่วนใหญ่มักเป็น localhost แต่บางที่อาจเป็น IP หรือชื่อเครื่องที่ Hosting กำหนด
    $host = "localhost";   
    $user = "it67040233126";        // ตรวจสอบชื่อ User จาก Hosting
    $pass = "X9M1F2F7";            // ตรวจสอบ Password จาก Hosting
    $dbname = "it67040233126";     // ตรวจสอบชื่อ Database จาก Hosting

    // เชื่อมต่อฐานข้อมูล
    $conn = mysqli_connect($host, $user, $pass, $dbname);

    // ตรวจสอบการเชื่อมต่อ
    if (!$conn) {
        // บน Hosting จริง ไม่ควรแสดง error_connect() ให้คนอื่นเห็นเพื่อความปลอดภัย 
        // แต่ช่วงทดสอบเปิดไว้ได้
        die("เชื่อมต่อไม่สำเร็จ: " . mysqli_connect_error());
    }

    // ตั้งค่าการเข้ารหัสเป็น utf8mb4 เพื่อรองรับอีโมจิและภาษาไทยที่สมบูรณ์
    mysqli_set_charset($conn, "utf8mb4");
?>