// document.addEventListener("DOMContentLoaded", function () {
//     const sid = getSIDFromURL();
//     fetchTreatmentChanges(sid);
// });

// // Get `sid` from URL
// function getSIDFromURL() {
//     const params = new URLSearchParams(window.location.search);
//     return params.get('sid');
// }

// // Fetch existing treatment changes
// function fetchTreatmentChanges(sid) {
//     if (!sid) return;

//     fetch(`fetch_treatment_changes.php?sid=${sid}`)
//         .then(response => response.json())
//         .then(data => {
//             console.log("Fetched data:", data);
//             if (Array.isArray(data)) {
//                 populateTable(data);
//             } else {
//                 console.error("Invalid data format:", data);
//             }
//         })
//         .catch(error => console.error("Error fetching data:", error));
// }


// // Populate table with fetched data
// function populateTable(data) {
//     let table = document.getElementById('treatmentChangesTable');
//     table.innerHTML = ''; // Clear existing rows

//     data.forEach(row => addRow(row)); // Add each row dynamically
// }

// // Add new row dynamically
// function addRow(data = {}) {
//     let table = document.getElementById('treatmentChangesTable');
//     let newRow = table.insertRow();
//     newRow.dataset.id = data.id || ''; // Store row ID for updates

//     newRow.innerHTML = `
//         <td><input type="date" name="regimen_changed__date[]" class="form-control" value="${data.date || ''}" /></td>
//         <td><input type="text" name="regimen_added_name[]" class="form-control" value="${data.drug || ''}" /></td>
//         <td>${generateRadioButtons('regimen_added_type[]', data.change_type, ['Dose lowered', 'Dose increased', 'Interrupted', 'Withdrawn'])}</td>
//         <td>${generateRadioButtons('regimen_changed__reason[]', data.reason, ['Drug resistance', 'Drug intolerance', 'Other'])}</td>
//         <td><input type="text" name="regimen_changed_other_reason[]" class="form-control" placeholder="Specify here" value="${data.other_reason || ''}" ${data.reason === 'Other' ? '' : 'disabled'} /></td>
//         <td>
//             <button type="button" class="btn btn-danger" onclick="removeRow(this, '${data.id || ''}')">Remove</button>
//         </td>
//     `;

//     attachReasonEventListeners();
// }

// // Generate radio buttons dynamically
// function generateRadioButtons(name, selectedValue, options) {
//     return options.map(value => `
//         <input class="form-check-input" type="radio" name="${name}" value="${value}" ${selectedValue === value ? 'checked' : ''}> ${value}<br>
//     `).join('');
// }

// // Handle reason selection (enables/disables "Other" input field)
// function attachReasonEventListeners() {
//     document.querySelectorAll('input[name="regimen_changed__reason[]"]').forEach(radio => {
//         radio.addEventListener('change', function () {
//             let otherReasonInput = this.closest('tr').querySelector('[name="regimen_changed_other_reason[]"]');
//             otherReasonInput.disabled = this.value !== 'Other';
//             otherReasonInput.required = this.value === 'Other';
//         });
//     });
// }

// // Remove row (UI & optionally from database)
// function removeRow(button, rowId) {
//     let row = button.closest('tr');
//     row.remove();

//     if (rowId) {
//         fetch('delete_treatment_change.php', {
//             method: 'POST',
//             headers: { 'Content-Type': 'application/json' },
//             body: JSON.stringify({ id: rowId })
//         })
//             .then(response => response.json())
//             .then(data => alert(data.message))
//             .catch(error => console.error('Error deleting record:', error));
//     }
// }

// // Save treatment changes (Insert/Update)
// function saveTreatmentChanges() {
//     let tableRows = document.querySelectorAll('#treatmentChangesTable tr');
//     let sid = getSIDFromURL();
//     let changes = [];

//     tableRows.forEach(row => {
//         let rowData = {
//             id: row.dataset.id || '', // Empty if new record
//             sid: sid,
//             date: row.querySelector('[name="regimen_changed__date[]"]').value,
//             drug: row.querySelector('[name="regimen_added_name[]"]').value,
//             change_type: getSelectedRadioValue(row, 'regimen_added_type[]'),
//             reason: getSelectedRadioValue(row, 'regimen_changed__reason[]'),
//             other_reason: row.querySelector('[name="regimen_changed_other_reason[]"]').value
//         };
//         changes.push(rowData);
//     });

//     fetch('save_treatment_changes.php', {
//         method: 'POST',
//         headers: { 'Content-Type': 'application/json' },
//         body: JSON.stringify(changes)
//     })
//         .then(response => response.json())
//         .then(data => {
//             alert(data.message);
//             fetchTreatmentChanges(sid); // Refresh table
//         })
//         .catch(error => console.error('Error saving data:', error));
// }

// // Get selected radio button value
// function getSelectedRadioValue(row, name) {
//     let selected = row.querySelector(`input[name="${name}"]:checked`);
//     return selected ? selected.value : '';
// }
