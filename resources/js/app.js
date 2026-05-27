require('./bootstrap');

function checkStatus(id) {

    setInterval(async () => {

        const res = await fetch(`/api/v1/conversions/${id}`);
        const data = await res.json();

        console.log(data.status);

        if (data.status === 'completed') {
            clearInterval(this);
            alert("Pronto para download!");
        }

    }, 3000);
}