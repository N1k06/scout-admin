async function populateTable(data) 
{
    const data_table = document.getElementById("data_table");
    data_table.innerHTML = "<tr><th>ID Persona</th> <th>Nome</th> <th>Cognome</th> <th>Data di nascita</th> <th>Luogo di nascita</th> <th>Num. di telefono</th> <th>Via di residenza</th> <th>Città di residenza</th> <th>CAP della città</th> <th>Genitore 1</th> <th>Genitore 2</th></tr>";

    data.forEach(array => 
    {
        const row = document.createElement("tr");
        const data1 = document.createElement("td");
        const data2 = document.createElement("td");
        const data3 = document.createElement("td");
        const data4 = document.createElement("td");
        const data5 = document.createElement("td");
        const data6 = document.createElement("td");
        const data7 = document.createElement("td");
        const data8 = document.createElement("td");
        const data9 = document.createElement("td");
        const dataA = document.createElement("td");
        const dataB = document.createElement("td");

        data1.textContent = array.id_persona;
        data2.textContent = array.nome;
        data3.textContent = array.cognome;
        data4.textContent = array.data_nascita;
        data5.textContent = array.luogo_nascita;
        data6.textContent = array.telefono;
        data7.textContent = array.via_residenza;
        data8.textContent = array.citta_residenza;
        data9.textContent = array.cap_residenza;
        dataA.textContent = array.id_tutore1;
        dataB.textContent = array.id_tutore2;

        row.appendChild(data1);
        row.appendChild(data2);
        row.appendChild(data3);
        row.appendChild(data4);
        row.appendChild(data5);
        row.appendChild(data6);
        row.appendChild(data7);
        row.appendChild(data8);
        row.appendChild(data9);
        row.appendChild(dataA);
        row.appendChild(dataB);

        data_table.appendChild(row);
    });
}

document.getElementById('getForm').addEventListener('submit', function (e) {
    e.preventDefault();

    // Prendi i dati del form in modo generico
    const form = e.target;
    const formData = new FormData(form);
    const data = {};

    formData.forEach((value, key) => {
      data[key] = value;
    });

    let str = "";

    if(data.id != "")
    {
      str = '../api/persone/' + data.id;
    }
    else
    {
      str = '../api/persone';
    }

    fetch(str, {
      method: 'GET'
    })
      .then(res => res.text())
      .then(data => alert('Risposta: ' + data))
      .catch(err => console.error('Errore:', err));
      populateTable(json.parse(data));
  });

document.getElementById('postForm').addEventListener('submit', function (e) {
    e.preventDefault();

    // Prendi i dati del form in modo generico
    const form = e.target;
    const formData = new FormData(form);
    const data = {};

    formData.forEach((value, key) => {
      data[key] = value;
    });

    fetch('../api/persone', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json'
      },
      body: JSON.stringify(data)
    })
      .then(res => res.text())
      .then(data => alert('Risposta: ' + data))
      .catch(err => console.error('Errore:', err));
  });

document.getElementById('putForm').addEventListener('submit', function (e) {
    e.preventDefault();

    // Prendi i dati del form in modo generico
    const form = e.target;
    const formData = new FormData(form);
    const data = {};
    const str = '../api/persone/' + document.getElementById('id').value;

    formData.forEach((value, key) => 
    {
      if(value != "")
      {
        data[key] = value;
      }
    });
    fetch(str, {
      method: 'PUT',
      headers: {
        'Content-Type': 'application/json'
      },
      body: JSON.stringify(data)
    })
      .then(res => res.text())
      .then(data => alert('Risposta: ' + data))
      .catch(err => console.error('Errore:', err));
  });

  document.getElementById('postForm').addEventListener('submit', function (e) {
    e.preventDefault();

    // Prendi i dati del form in modo generico
    const form = e.target;
    const formData = new FormData(form);
    const data = {};

    formData.forEach((value, key) => {
      data[key] = value;
    });

    fetch('../api/persone', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json'
      },
      body: JSON.stringify(data)
    })
      .then(res => res.text())
      .then(data => alert('Risposta: ' + data))
      .catch(err => console.error('Errore:', err));
  });