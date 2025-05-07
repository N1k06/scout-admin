//Scritp javascript che prenda gli attributi di persona e tramite il pulsante Invia li manda al webservice

document.getElementById('submitBtn').addEventListener('click', function() {

    //Preleva i dati dal modulo
    const nome = document.getElementById('nome').value;
    const cognome = document.getElementById('cognome').value;
    const data_nascita = document.getElementById('data_nascita').value;
    const luogo_nascita = document.getElementById('luogo_nascita').value;
    const telefono = document.getElementById('telefono').value;
    const via_residenza = document.getElementById('via_residenza').value;
    const citta_residenza = document.getElementById('citta_residenza').value;
    const cap_residenza = document.getElementById('cap_residenza').value;

    // Creare un oggetto con i dati da inviare
    const persona = {
        nome: nome,
        cognome: cognome,
        data_nascita: data_nascita,
        luogo_nascita: luogo_nascita,
        telefono: telefono,
        via_residenza: via_residenza,
        citta_residenza: citta_residenza,
        cap_residenza: cap_residenza
    };

    // Inviare i dati al web service tramite Fetch API
    fetch('/api/persone', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(persona)
    })
    .then(response => response.json())
    .then(data => {
        console.log('Dati inviati con successo:', data);
        alert('Dati inviati con successo!');
    })
    .catch((error) => {
        console.error('Errore nell\'invio dei dati:', error);
        alert('Errore nell\'invio dei dati');
    });
});