const topicInsert = event => {
    event.preventDefault();

    const topicName = document.getElementById('topicName').value;
    const extraInfo = document.getElementById('extraInfo').value;

    const topic = {
        topicName,
        extraInfo
    };

    const settings = {
        method: 'POST',
        headers: {
            'Content-type': 'application/x-www-form-urlencoded; charset=UTF-8'
        },
        body: `data=${JSON.stringify(topic)}`
    };

    ajax('src/api.php/topicInsert', settings, false, 'index.html');
};

(function() {
    const insertTopicBtn = document.getElementById('Insert');

    insertTopicBtn.addEventListener('click', topicInsert);

//    const tName = "Българска";
//    const eInfo = "Всички подтипове";

//     const newTopic = {
//         topicName: tName,
//         extraInfo: eInfo
//     };

//     const settings = {
//         method: 'POST',
//         headers: {
//             'Content-type': 'application/x-www-form-urlencoded; charset=UTF-8'
//         },
//         body: `data=${JSON.stringify(newTopic)}`
//     };

//     ajax('src/api.php/topicInsert', settings, false, 'index.html');
})();