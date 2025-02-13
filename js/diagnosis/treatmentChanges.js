function addRow() {
    let table = document.getElementById("treatmentChangesTable");
    let row = table.insertRow();
    row.innerHTML = `
            <td><input type="date" name="date[]" class="form-control" required></td>
            <td><input type="text" name="drug[]" class="form-control" required></td>
            <td>
                <select name="type_of_change[]" class="form-control" required>
                    <option value="Increase Dose">Increase Dose</option>
                    <option value="Decrease Dose">Decrease Dose</option>
                    <option value="Switch Drug">Switch Drug</option>
                </select>
            </td>
            <td><input type="text" name="reason[]" class="form-control" required></td>
            <td><input type="text" name="specify[]" class="form-control"></td>
            <td><button type="button" class="btn btn-danger" onclick="removeRow(this)">Remove</button></td>
        `;
}

function removeRow(button) {
    let row = button.closest("tr");
    row.remove();
}

function saveTreatmentChanges() {
    let formData = new FormData();
    let rows = document.querySelectorAll("#treatmentChangesTable tr");

    rows.forEach(row => {
        formData.append("date[]", row.querySelector("[name='date[]']").value);
        formData.append("drug[]", row.querySelector("[name='drug[]']").value);
        formData.append("type_of_change[]", row.querySelector("[name='type_of_change[]']").value);
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
        })
        .catch(error => console.error("Error:", error));
}