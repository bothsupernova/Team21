document.addEventListener("DOMContentLoaded", function () {
    const table = document.querySelector(".square-table");
    const colorSelects = document.querySelectorAll(
        'select[name^="color_code"]'
    );
    let previousValues = {}; // Object to store previous values for each select

    function initializePreviousValues() {
        colorSelects.forEach((select, index) => {
            previousValues[index] = select.value;
        });
    }

    function handleColorChange(select, index) {
        const isColorInUse = Array.from(colorSelects).some(
            (otherSelect, otherIndex) => {
                return (
                    otherIndex !== index && otherSelect.value === select.value
                );
            }
        );

        if (!isColorInUse) {
            previousValues[index] = select.value;
            removeErrorSummary(); // Ensure any existing error message is removed
            applyColors();
            return;
        }

        displayErrorMessage(select, index); // Display error if the color is already in use
    }

    function displayErrorMessage(select, index) {
        removeErrorSummary();

        const errorSummary = document.createElement("div");
        errorSummary.classList.add("error-summary");

        const errorMessageParagraph = document.createElement("p");
        errorMessageParagraph.textContent =
            "Please review the following error(s):";
        errorSummary.appendChild(errorMessageParagraph);

        const errorList = document.createElement("ul");
        const errorItem = document.createElement("li");

        const errorMessage = `Color ${select.value} already in use. Reverting to previous color ${previousValues[index]}. Please select a different color.`;
        errorItem.textContent = errorMessage;
        errorList.appendChild(errorItem);
        errorSummary.appendChild(errorList);

        const formSection = document.querySelector("#color-coordinates");
        formSection.insertBefore(errorSummary, formSection.firstChild);

        select.value = previousValues[index]; // Revert to the previous value
    }

    function removeErrorSummary() {
        const errorSummary = document.querySelector(".error-summary");
        if (errorSummary) {
            errorSummary.remove();
        }
    }

    function applyColors() {
        const colors = Array.from(colorSelects).map((select) =>
            select.value.trim()
        );
        const rows = table.querySelectorAll("tr");
        rows.forEach((row, rowIndex) => {
            const cells = row.querySelectorAll("td");

            cells.forEach((cell, cellIndex) => {
                if (rowIndex === 0 || cellIndex === 0) {
                    cell.style.backgroundColor = "";
                    return;
                }

                let colorIndex =
                    ((rowIndex - 1) * (cells.length - 1) + (cellIndex - 1)) %
                    colors.length;
                cell.style.backgroundColor = colors[colorIndex];
            });
        });
    }

    initializePreviousValues();

    colorSelects.forEach((select, index) => {
        select.addEventListener("change", function () {
            handleColorChange(select, index);
        });
    });

    applyColors();
});

document
    .getElementById("printable-view-link")
    .addEventListener("click", function () {
        const colorParams = Array.from(
            document.querySelectorAll('select[name^="color_code"]')
        )
            .map((select) => encodeURIComponent(select.value))
            .join(",");

        const baseUrl = "print-view.php";
        const queryParams = `rows_columns=${encodeURIComponent(
            document.getElementById("rows-columns").value
        )}&num_colors=${encodeURIComponent(
            document.getElementById("num-colors").value
        )}&colors=${colorParams}`;
        const fullUrl = `${baseUrl}?${queryParams}`;

        window.location.href = fullUrl;
    });
