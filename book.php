<?php include 'includes/header.php'; ?>
<h2>Book an Appointment</h2>
<form action="controllers/AppointmentController.php" method="post">
    <label>Name:</label><br><input type="text" name="name" required><br>
    <label>Email:</label><br><input type="email" name="email" required><br>
    <label>Service:</label><br>
    <select name="service">
        <option>Senior Stylist's cut</option>
        <option>Junior Stylist's cut</option>
        <option>Student's Hair cut</option>
        <option>Hot Oil Massage</option>
        <option>Hair Spa</option>
    </select><br>
    <label>Date:</label><br><input type="date" name="date" required><br>
    <button type="submit">Confirm Booking</button>
</form>
<?php include 'includes/footer.php'; ?>