// ✅ Helper functions for modals
function openModal(id) {
  document.getElementById(id).classList.remove('hidden');
  document.getElementById(id).classList.add('flex');
}
function closeModal(id) {
  document.getElementById(id).classList.add('hidden');
  document.getElementById(id).classList.remove('flex');
}

document.addEventListener('DOMContentLoaded', () => {
  // Use event delegation for buttons inside DataTables rows
  const table = document.getElementById('patientTable');

  table.addEventListener('click', function (e) {
    const target = e.target.closest('button');
    if (!target) return;

    const row = target.closest('tr');
    const c = row.querySelectorAll('td');

    // 🔹 View Button
    if (target.classList.contains('view-btn')) {
      document.getElementById('view_patient_id').innerText = c[1]?.innerText || '';
      document.getElementById('view_fullname').innerText = c[2]?.innerText || '';
      document.getElementById('view_age').innerText = c[3]?.innerText || '';
      document.getElementById('view_sex').innerText = c[4]?.innerText || '';
      document.getElementById('view_dob').innerText = c[5]?.innerText || '';
      document.getElementById('view_address').innerText = c[6]?.innerText || '';
      document.getElementById('view_contact').innerText = c[7]?.innerText || '';
      document.getElementById('view_height').innerText = c[8]?.innerText || '';
      document.getElementById('view_weight').innerText = c[9]?.innerText || '';
      document.getElementById('view_notes').innerText = c[10]?.innerText || '';
      openModal('viewModal');
    }

    // 🔹 Edit Button
    if (target.classList.contains('edit-btn')) {
      document.getElementById('edit_id').value = c[0]?.innerText || '';
      document.getElementById('edit_patient_id').value = c[1]?.innerText || '';
      document.getElementById('edit_fullname').value = c[2]?.innerText || '';
      document.getElementById('edit_age').value = c[3]?.innerText || '';
      document.getElementById('edit_sex').value = c[4]?.innerText || '';
      document.getElementById('edit_dob').value = c[5]?.innerText || '';
      document.getElementById('edit_address').value = c[6]?.innerText || '';
      document.getElementById('edit_contact').value = c[7]?.innerText || '';
      document.getElementById('edit_height').value = c[8]?.innerText || '';
      document.getElementById('edit_weight').value = c[9]?.innerText || '';
      document.getElementById('edit_notes').value = c[10]?.innerText || '';
      openModal('editModal');
    }

  });

  

// Open modal when delete button is clicked
document.addEventListener('click', e => {
  const btn = e.target.closest('.delete-btn');
  if (btn) {
    const row = btn.closest('tr');
    const patientId = row.querySelector('td:nth-child(1)')?.textContent.trim();
    const fullname = row.querySelector('td:nth-child(2)')?.textContent.trim();

    deleteId = btn.getAttribute('data-id');
    document.getElementById('deleteInfo').textContent = 
      `ID: ${patientId} — ${fullname}`;

    document.getElementById('deleteModal').classList.remove('hidden');
  }
});

// Close modal
document.getElementById('cancelDelete').addEventListener('click', () => {
  document.getElementById('deleteModal').classList.add('hidden');
  deleteId = null;
});

// Confirm delete
document.getElementById('confirmDelete').addEventListener('click', () => {
  console.log('✅ Confirm Delete clicked! ID:', deleteId);
  if (deleteId) {
    window.location.href = `../php/backend1.php?action=delete&id=${deleteId}`;
  }
});


});


