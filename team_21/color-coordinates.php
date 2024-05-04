<?php
$company_name = "DevDreamers";

$error_messages = [];

$max_rows_columns = 26;
$max_num_colors = 10;

$input_box_width = "30px";

function validate_input($input, $min, $max, $field_name)
{
    $value = filter_var($input, FILTER_VALIDATE_INT, ["options" => ["min_range" => $min, "max_range" => $max]]);
    if ($value === false) {
        return "$field_name must be a valid integer between $min and $max.";
    }
    return null;
}

// Check if the form was submitted and the required fields are set
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['rows_columns'], $_GET['num_colors'])) {
    // Validate 'rows_columns' input
    $error_message = validate_input($_GET['rows_columns'], 1, $max_rows_columns, "Rows & Columns");
    if ($error_message !== null) {
        $error_messages[] = $error_message;
    }

    // Validate 'num_colors' input
    $error_message = validate_input($_GET['num_colors'], 1, $max_num_colors, "Number of Colors");
    if ($error_message !== null) {
        $error_messages[] = $error_message;
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Color Coordinate Generation - DevDreamers</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/table-styles.css">
</head>

<?php include ("content/header.php") ?>

<body>
    <?php include ("content/navbar.php"); ?>

    <main>
        <section id="color-coordinates">

            <!-- Error summary box -->
            <?php if (count($error_messages) > 0): ?>
                <div class="error-summary">
                    <p>Please review the following error(s):</p>
                    <ul>
                        <?php foreach ($error_messages as $error_message): ?>
                            <li>
                                <?php echo $error_message; ?>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>

                <!-- Error summary box placeholder for JavaScript errors -->
                <div id="js-error-summary" class="error-summary" style="display: none;">
                    <p>Please review the following errors:</p>
                    <ul>
                        <!-- JavaScript dynamically insert error items here -->
                    </ul>
                </div>

            <?php endif; ?>

            <form id="color-coordinates-form" method="GET" action="color-coordinates.php">
                <div class="form-field">
                    <label for="rows-columns">Rows & Columns (1-26):</label>
                    <input type="text" id="rows-columns" name="rows_columns" required
                        style="width: <?php echo $input_box_width; ?>"
                        value="<?php echo isset($_GET['rows_columns']) ? htmlspecialchars($_GET['rows_columns']) : ''; ?>">
                </div>

                <div class="form-field">
                    <label for="num-colors">Number of Colors (1-10):</label>
                    <input type="text" id="num-colors" name="num_colors" required
                        style="width: <?php echo $input_box_width; ?>"
                        value="<?php echo isset($_GET['num_colors']) ? htmlspecialchars($_GET['num_colors']) : ''; ?>">
                </div>

                <input type="submit" value="Generate" class="button">
            </form>

            <?php if (count($error_messages) === 0 && isset($_GET['rows_columns'], $_GET['num_colors'])): ?>
                <?php
                $rows_columns = intval($_GET['rows_columns']);
                $num_colors = intval($_GET['num_colors']);
                ?>

                <!-- First Table for Color Inputs -->
                <!-- Color Dropdowns -->
                <table class="color-table">
                    <?php
                    $colors = ["Red", "Orange", "Yellow", "Green", "Blue", "Purple", "Grey", "Brown", "Black", "Teal"];
                    $used_colors = []; // Keep track of used colors

                    // Loop through the number of colors to display
                    for ($i = 0; $i < $num_colors; $i++) {
                        // Find the first color not already used
                        $color = "";
                        foreach ($colors as $potential_color) {
                            if (!in_array($potential_color, $used_colors)) {
                                $color = $potential_color; // Assign the unused color
                                $used_colors[] = $color; // Mark this color as used
                                break; // Exit the loop once a color is assigned
                            }
                        }

                        // HTML to display a row for color selection
                        echo '<tr>';
                        echo '<td style="width: 20%;">Color ' . ($i + 1) . ':</td>';
                        echo '<td style="width: 80%;">';
                        echo '<select name="color_code[' . $i . ']">';

                        // Loop through each color for the dropdown options
                        foreach ($colors as $color_option) {
                            $selected = $color_option === $color ? 'selected' : '';
                            echo '<option value="' . $color_option . '" ' . $selected . '>' . $color_option . '</option>';
                        }

                        echo '</select>';
                        echo '</td>';
                        echo '</tr>';
                    }
                    ?>

                </table>

                <!-- Second Square Table -->
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
                                    <!-- Regular cell -->
                                    <td></td>
                                <?php endif; ?>
                            <?php endfor; ?>
                        </tr>
                    <?php endfor; ?>
                </table>

                <br>

                <div class="printable-view-button">
                    <a href="javascript:void(0);" id="printable-view-link" class="button">Printable View</a>
                </div>

            <?php endif; ?>

        </section>

    </main>

    <?php include ("content/footer.php"); ?>
    <script src="assets/js/main.js"></script>
    <script src="assets/js/color-coordinates.js"></script>
</body>

</html>