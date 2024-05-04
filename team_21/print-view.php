<?php
$rows_columns = $_GET['rows_columns'] ?? '';
$num_colors = $_GET['num_colors'] ?? '';
$colors = isset($_GET['colors']) ? explode(',', $_GET['colors']) : [];

$rows_columns = intval($rows_columns);
?>

<!DOCTYPE HTML>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print Page - team_21</title>
    <link rel="stylesheet" href="assets/css/print-view.css">
    <link rel="stylesheet" href="assets/css/table-styles.css">
</head>

<?php include ("content/header.php"); ?>

<body>
    <table class="color-table">
        <?php
        // Loop through each color
        for ($i = 0; $i < count($colors); $i++) {
            echo "<tr>";
            echo "<td>Color " . ($i + 1) . "</td>";
            echo "<td>";
            echo htmlspecialchars($colors[$i]);
            echo "</td>";
            echo "</tr>";
        }
        ?>
    </table>

    <table class="square-table">
        <?php for ($i = 0; $i <= $rows_columns; $i++): ?>
            <tr>
                <?php for ($j = 0; $j <= $rows_columns; $j++): ?>
                    <?php if ($i == 0 && $j > 0): ?>
                        <!-- Top row labels (A-Z) -->
                        <td>
                            <?php echo chr(64 + $j); ?>
                        </td>
                    <?php elseif ($j == 0 && $i > 0): ?>
                        <!-- Left column numbers (1-n) -->
                        <td>
                            <?php echo $i; ?>
                        </td>
                    <?php else: ?>
                        <!-- Regular cell with color -->
                        <td <?php if ($i > 0 && $j > 0) {
                            // Calculate the color index based on the position
                            $colorIndex = (($i - 1) * $rows_columns + ($j - 1)) % count($colors);
                            // Apply the background color
                            echo "style='background-color: " . htmlspecialchars($colors[$colorIndex]) . "'";
                        } ?>></td>
                    <?php endif; ?>
                <?php endfor; ?>
            </tr>
        <?php endfor; ?>
    </table>

    <?php include ("content/footer.php"); ?>
    <script src="assets/js/main.js"></script>
    <script src="assets/js/color-coordinates.js"></script>
</body>

</html>