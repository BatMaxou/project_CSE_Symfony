window.addEventListener('load', function() {
    var alert_success = document.getElementsByClassName('alert-success');
    var alert_error = document.getElementsByClassName('alert-error');

    function close(ind) {
        console.log(ind)
        if (alert_error[ind]) {
            alert_error[ind].style.display = 'none';
        } else if (alert_success) {
            alert_success[ind].style.display = 'none';
        }
    }

    var ind = 0;
    var button = document.querySelectorAll('.closebtn'); 
    if (button) {
        button.forEach(function(button) {
            button.addEventListener('click', function() {
                close(ind);
                ind ++;
            });
        });
    }

    setTimeout(() => {
        if (alert_success) {
            alert_success[ind].style.display = 'none';
        }
    }, 4000);
});