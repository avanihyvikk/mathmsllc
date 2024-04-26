<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Untitled Document</title>
</head>
<!-- Display the user's direct reports -->
<h2>Direct Reports</h2>
<ul>
    <?php foreach ($directReports as $report): ?>
        <li><?= $report->first_name ?> <?= $report->last_name ?></li>
    <?php endforeach; ?>
</ul>

<!-- Display the manager's direct reports -->
<h2>Manager's Direct Reports</h2>
<ul>
    <?php foreach ($managerDirectReports as $report): ?>
        <li><?= $report->first_name ?> <?= $report->last_name ?></li>
    <?php endforeach; ?>
</ul>

<!-- Display the manager and above hierarchy -->
<h2>Manager and Above Hierarchy</h2>
<ul>
    <?php foreach ($managerAndAbove as $manager): ?>
        <li><?= $manager->first_name ?> <?= $manager->last_name ?></li>
    <?php endforeach; ?>
</ul>

<body>
</body>
</html>