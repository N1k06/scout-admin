async function fetchData(link)
{
    const url = link;
    
    try
    {
        const response = await fetch(url);
        const data = await response.json();
        return data;
    }
    catch (error)
    {
        console.error(error.message);
    }
}

async function populateParagraph(link) 
{
    console.log("Calling API:", link);
    const data = await fetchData(link);
    console.log("Received data:", data);
    const data_table = document.getElementById("data_table");
    data_table.innerHTML = "<tr><th>Articolo</th> <th>Categoria</th> <th>Sotto Categoria</th></tr>";

    data.forEach(array => 
    {
        const row = document.createElement("tr");
        const data1 = document.createElement("td");
        const data2 = document.createElement("td");
        const data3 = document.createElement("td");

        data1.textContent = array.nome;
        data2.textContent = array.categoria;
        data3.textContent = array.sottoCategoria;

        row.appendChild(data1);
        row.appendChild(data2);
        row.appendChild(data3);

        data_table.appendChild(row);
    });
}

document.getElementById("btn").addEventListener("click", function()
{
    if(document.getElementById("id").value != "")
    {
        populateParagraph(`/api/persone/${document.getElementById("id").value}`);
    }
    else
    {
        populateParagraph("/api/persone");
    }
});