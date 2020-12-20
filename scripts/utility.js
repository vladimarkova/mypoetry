const ajax = (url, settings, successUrl) => {
    fetch(url, settings)
        .then(response => response.json())
        .then(data =>  load(data, successUrl))
        .catch(error => console.log(error));
};

const load = (data, url) => {
    if(data.success) {
        const resp = document.getElementById('resp');
        resp.innerHTML = data.message;
    } else {
        const errors = document.getElementById('errors');
        errors.innerHTML = data.error;
    }
    var topicName = document.getElementById('topicName');
    var extraInfo = document.getElementById('extraInfo');
    topicName.value = "";
    extraInfo.value = "";
};