// document.addEventListener("DOMContentLoaded", function () {
//     const sid = getSIDFromURL();
//     fetchTreatmentChanges(sid);
// });

// function getSIDFromURL() {
//     const params = new URLSearchParams(window.location.search);
//     return params.get('sid');
// }

// function fetchTreatmentChanges(sid) {
//     if (!sid) return;

//     fetch(`fetch_treatment_changes.php?sid=${sid}`)
//         .then(response => response.json())
//         .then(data => populateTable(data))
//         .catch(error => console.error('Error fetching data:', error));
// }

// function populateTable(data) {
//     let table = document.getElementById('treatmentChangesTable');
//     table.innerHTML = ''; // Clear existing rows

//     data.forEach(row => {
//         addRow(row);
//     });
// }

// function addRow(data = {}) {
//     let table = document.getElementById('treatmentChangesTable');
//     let newRow = table.insertRow();
//     newRow.dataset.id = data.id || ''; // Store row ID for updates

//     newRow.innerHTML = `
//         <td><input type="date" name="regimen_changed__date[]" class="form-control" value="${data.date || ''}" /></td>
//         <td><input type="text" name="regimen_added_name[]" class="form-control" value="${data.drug || ''}" /></td>
//         <td>
//             <div class="form-check">
//                 ${generateRadioButtons('regimen_added_type[]', data.change_type, ['Dose lowered', 'Dose increased', 'Interrupted', 'Withdrawn'])}
//             </div>
//         </td>
//         <td>
//             <div class="form-check">
//                 ${generateRadioButtons('regimen_changed__reason[]', data.reason, ['Drug resistance', 'Drug intolerance', '96'])}
//             </div>
//         </td>
//         <td><input type="text" name="regimen_changed_other_reason[]" class="form-control" placeholder="Specify here" value="${data.other_reason || ''}" ${data.reason === '96' ? '' : 'disabled'} /></td>
//         <td>
//             <button type="button" class="btn btn-danger" onclick="removeRow(this)">Remove</button>
//         </td>
//     `;

//     attachReasonEventListeners();
// }

// function generateRadioButtons(name, selectedValue, options) {
//     return options.map(value => `
//         <input class="form-check-input" type="radio" name="${name}" value="${value}" ${selectedValue === value ? 'checked' : ''}> ${value}<br>
//     `).join('');
// }

// function attachReasonEventListeners() {
//     document.querySelectorAll('.other-reason').forEach(radio => {
//         radio.addEventListener('change', function () {
//             let input = this.closest('tr').querySelector('[name="regimen_changed_other_reason[]"]');
//             input.disabled = !this.checked;
//             input.required = this.checked;
//         });
//     });
// }

// function removeRow(button) {
//     let row = button.closest('tr');
//     row.remove();
// }

// function saveTreatmentChanges() {
//     let tableRows = document.querySelectorAll('#treatmentChangesTable tr');
//     let sid = getSIDFromURL();
//     let changes = [];

//     tableRows.forEach(row => {
//         let rowData = {
//             id: row.dataset.id || '', // Existing ID or empty for new rows
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

// function getSelectedRadioValue(row, name) {
//     let selected = row.querySelector(`input[name="${name}"]:checked`);
//     return selected ? selected.value : '';
// }
