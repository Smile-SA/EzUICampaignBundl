(function(global, doc) {
    'use strict';

    document.addEventListener("DOMContentLoaded", function(event) {
        var campaignSubmits = doc.querySelectorAll('.smilecampaign-submit');
        campaignSubmits.forEach(function (campaignSubmit) {
            campaignSubmit.addEventListener('click', function(event) {
                var campaignID = campaignSubmit.getAttribute('data-id'),
                    campaignInput = doc.querySelector('#campaign-' + campaignID),
                    campaignPath = campaignInput.getAttribute('data-path'),
                    campaignEmail = campaignInput.value.trim();

                if (typeof campaignEmail == undefined || campaignEmail == '') {
                    campaignEmail = '';
                }

                var xhr = new XMLHttpRequest();

                xhr.onreadystatechange = function () {
                    var response;

                    if (xhr.readyState === 4) {
                        response = JSON.parse(xhr.response);

                        if (xhr.status === 400 && response.message) {
                            var messageSpan = doc.querySelector('#campaign-container-' + campaignID + ' .message');
                            messageSpan.innerHTML = response.message;
                            return;
                        }

                        if (xhr.status === 200) {
                            var campaignContainer = doc.querySelector('#campaign-container-' + campaignID);
                            campaignContainer.innerHTML = response.message;
                        }
                    }
                };

                var data = new FormData();
                data.append('email', campaignEmail);

                xhr.open('POST', campaignPath, true);
                xhr.send(data);
            }, false);
        });
    });
})(window, document);
