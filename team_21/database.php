<?php
// Simulated database using an array
$colors = [
    'red' => '#FF0000',
    'blue' => '#0000FF',
    'green' => '#008000',
    'yellow' => '#FFFF00',
    'orange' => '#FFA500',
    'purple' => '#800080',
    'cyan' => '#00FFFF',
    'magenta' => '#FF00FF',
    'lime' => '#00FF00',
    'pink' => '#FFC0CB'
];

// Handling POST requests
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['add'])) {
        $message = addColor($_POST['name'], $_POST['hex']);
    } elseif (isset($_POST['edit'])) {
        $message = editColor($_POST['oldName'], $_POST['newName'], $_POST['newHex']);
    } elseif (isset($_POST['delete'])) {
        $message = deleteColor($_POST['name']);
    }
}

// Function to add a color
function addColor($name, $hex) {
    global $colors;
    if (empty($name) || empty($hex)) {
        return "Error: Color name or hex value cannot be empty.";
    }
    if (!isset($colors[$name]) && !in_array($hex, $colors)) {
        $colors[$name] = $hex;
        return "Color added successfully.";
    } else {
        return "Error: Color name or hex already exists.";
    }
}

// Function to edit a color
function editColor($oldName, $newName, $newHex) {
    global $colors;
    if (empty($newName) || empty($newHex)) {
        return "Error: New color name or hex value cannot be empty.";
    }
    if (isset($colors[$oldName])) {
        if (!isset($colors[$newName]) && !in_array($newHex, $colors)) {
            unset($colors[$oldName]);
            $colors[$newName] = $newHex;
            return "Color edited successfully.";
        }
        return "Error: New color name or hex already exists.";
    }
    return "Error: Original color does not exist.";
}

// Function to delete a color
function deleteColor($name) {
    global $colors;
    if (count($colors) > 2) {
        unset($colors[$name]);
        return "Color deleted successfully.";
    } else {
        return "Error: Cannot delete color. Minimum of two colors required.";
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Colors</title>
    <link rel="stylesheet" href="assets/css/print-view.css">
    <link rel="stylesheet" href="assets/css/table-styles.css">
    <link rel="stylesheet" href="assets/css/styles.css">
    
    <style>
        form {
            margin: 20px;
            padding: 10px;
            border: 1px solid #ccc;
        }

        .error, .success {
            color: white;
            padding: 2px;
            margin: 5px 0;
        }

        .error {
            background-color: red;
        }

        .success {
            background-color: green;
        }
    </style>
</head>
<body>
    <?php if (!empty($message)): ?>
        <p class="<?= strpos($message, 'Error') !== false ? 'error' : 'success' ?>"><?= $message ?></p>
    <?php endif; ?>

    <form method="post">
        <h2>Add Color</h2>
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required>
        <label for="hex">Hex Value:</label>
        <input type="text" id="hex" name="hex" required>
        <button type="submit" name="add">Add Color</button>
    </form>

    <form method="post">
        <h2>Edit Color</h2>
        <label for="oldName">Old Name:</label>
        <select id="oldName" name="oldName">
            <?php foreach ($colors as $name => $hex): ?>
                <option value="<?= $name ?>"><?= $name ?></option>
            <?php endforeach; ?>
        </select>
        <label for="newName">New Name:</label>
        <input type="text" id="newName" name="newName" required>
        <label for="newHex">New Hex:</label>
        <input type="text" id="newHex" name="newHex" required>
        <button type="submit" name="edit">Edit Color</button>
    </form>

    <form method="post">
        <h2>Delete Color
