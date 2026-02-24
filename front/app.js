const API = 'http://localhost:8080';

// Charge la liste des équipements depuis l'API au démarrage
async function loadEquipments() {
  const select = document.getElementById('equipment');

  try {
    const response = await fetch(`${API}/api/equipments`);
    const equipments = await response.json();

    // Remplit le select avec les équipements
    select.innerHTML = '<option value="">-- Choisir un matériel --</option>';
    equipments.forEach(eq => {
      const option = document.createElement('option');
      option.value = eq.id;
      option.textContent = `${eq.name} (${eq.reference})`;
      select.appendChild(option);
    });

  } catch (err) {
    select.innerHTML = '<option value="">Erreur de chargement</option>';
  }
}

// Affiche un message vert (succès) ou rouge (erreur)
function showMessage(text, type) {
  const msg = document.getElementById('message');
  msg.textContent = text;
  msg.className = type;
}

// Envoi du formulaire sans rechargement de page
document.getElementById('reservationForm').addEventListener('submit', async (e) => {
  e.preventDefault();

  const body = {
    equipment_id: document.getElementById('equipment').value,
    user_email:   document.getElementById('email').value,
    start_date:   document.getElementById('startDate').value,
    end_date:     document.getElementById('endDate').value,
  };

  try {
    // Envoie les données au backend en JSON
    const response = await fetch(`${API}/api/reservations`, {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify(body),
    });

    const result = await response.json();

    if (response.ok) {
      showMessage('✅ ' + result.message, 'success');
      e.target.reset();
      loadEquipments();
    } else {
      showMessage('❌ ' + result.error, 'error');
    }

  } catch (err) {
    showMessage('❌ Erreur de connexion au serveur.', 'error');
  }
});

// Lancement au démarrage
loadEquipments();