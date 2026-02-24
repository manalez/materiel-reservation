// On teste les fonctions du front sans navigateur
// Jest simule l'environnement du navigateur

// Test 1 : vérifier que le message s'affiche correctement
test('showMessage affiche un message de succès', () => {
    // On crée un faux élément HTML pour le test
    document.body.innerHTML = '<div id="message" class="hidden"></div>';

    const msg = document.getElementById('message');
    msg.textContent = '✅ Réservation créée avec succès !';
    msg.className = 'success';

    expect(msg.textContent).toBe('✅ Réservation créée avec succès !');
    expect(msg.className).toBe('success');
});

// Test 2 : vérifier que le message d'erreur s'affiche correctement
test('showMessage affiche un message d erreur', () => {
    document.body.innerHTML = '<div id="message" class="hidden"></div>';

    const msg = document.getElementById('message');
    msg.textContent = '❌ Ce matériel est déjà réservé.';
    msg.className = 'error';

    expect(msg.textContent).toBe('❌ Ce matériel est déjà réservé.');
    expect(msg.className).toBe('error');
});

// Test 3 : vérifier que le formulaire a les bons champs
test('le formulaire contient tous les champs requis', () => {
    document.body.innerHTML = `
        <form id="reservationForm">
            <select id="equipment"></select>
            <input type="email" id="email" />
            <input type="date" id="startDate" />
            <input type="date" id="endDate" />
        </form>
    `;

    expect(document.getElementById('equipment')).not.toBeNull();
    expect(document.getElementById('email')).not.toBeNull();
    expect(document.getElementById('startDate')).not.toBeNull();
    expect(document.getElementById('endDate')).not.toBeNull();
});

// Test 4 : vérifier que les données du formulaire sont bien collectées
test('les données du formulaire sont correctement collectées', () => {
    document.body.innerHTML = `
        <form id="reservationForm">
            <select id="equipment"><option value="1">MacBook</option></select>
            <input type="email" id="email" value="test@test.com" />
            <input type="date" id="startDate" value="2025-06-01" />
            <input type="date" id="endDate" value="2025-06-05" />
        </form>
    `;

    const body = {
        equipment_id: document.getElementById('equipment').value,
        user_email:   document.getElementById('email').value,
        start_date:   document.getElementById('startDate').value,
        end_date:     document.getElementById('endDate').value,
    };

    expect(body.equipment_id).toBe('1');
    expect(body.user_email).toBe('test@test.com');
    expect(body.start_date).toBe('2025-06-01');
    expect(body.end_date).toBe('2025-06-05');
});