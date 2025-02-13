document.addEventListener("DOMContentLoaded", loadTreatmentChanges);

function addRow(id = "", date = "", drug = "", changes = "", reason = "", specify = "") {
    let table = document.getElementById("treatmentChangesTable");
    let row = table.insertRow();
    row.dataset.id = id; // Store row ID for updates

    row.innerHTML = `
            <td><input type="date" name="date[]" class="form-control" value="${date}" required></td>
            <td><input type="text" name="drug[]" class="form-control" value="${drug}" required></td>
            <td>
                <select name="changes[]" class="form-control" required>
                    <option value="Increase Dose" ${changes === "Increase Dose" ? "selected" : ""}>Increase Dose</option>
                    <option value="Decrease Dose" ${changes === "Decrease Dose" ? "selected" : ""}>Decrease Dose</option>
                    <option value="Switch Drug" ${changes === "Switch Drug" ? "selected" : ""}>Switch Drug</option>
                </select>
            </td>
            <td><input type="text" name="reason[]" class="form-control" value="${reason}" required></td>
            <td><input type="text" name="specify[]" class="form-control" value="${specify}"></td>
            <td>
                <button type="button" class="btn btn-danger" onclick="deleteRow(this, '${id}')">Delete</button>
            </td>
        `;
}

function deleteRow(button, id) {
    let row = button.closest("tr");
    row.remove();

    if (id) {
        fetch("delete_treatment_change.php", {
            method: "POST",
            body: new URLSearchParams({ id: id })
        })
            .then(response => response.text())
            .then(data => {
                alert("Treatment change deleted successfully!");
            })
            .catch(error => console.error("Error:", error));
    }
}

function saveTreatmentChanges() {
    let formData = new FormData();
    let rows = document.querySelectorAll("#treatmentChangesTable tr");

    rows.forEach(row => {
        formData.append("id[]", row.dataset.id || "");
        formData.append("date[]", row.querySelector("[name='date[]']").value);
        formData.append("drug[]", row.querySelector("[name='drug[]']").value);
        formData.append("changes[]", row.querySelector("[name='changes[]']").value);
        formData.append("reason[]", row.querySelector("[name='reason[]']").value);
        formData.append("specify[]", row.querySelector("[name='specify[]']").value);
    });

    fetch("save_treatment_changes.php", {
        method: "POST",
        body: formData
    })
        .then(response => response.text())
        .then(data => {
            alert("Treatment changes saved successfully!");
            loadTreatmentChanges(); // Reload table after saving
        })
        .catch(error => console.error("Error:", error));
}

function loadTreatmentChanges() {
    fetch("get_treatment_changes.php")
        .then(response => response.json())
        .then(data => {
            let table = document.getElementById("treatmentChangesTable");
            table.innerHTML = ""; // Clear existing table data

            data.forEach(item => {
                addRow(item.id, item.date, item.drug, item.changes, item.reason, item.specify);
            });
        })
        .catch(error => console.error("Error fetching treatment changes:", error));
}