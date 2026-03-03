
function insert(value) {
        document.getElementById("result").value += value;
    }

    function calculate() {
        var x = document.getElementById("result").value;
        var y = eval(x);
        document.getElementById("result").value = y;
    }

    function clearScreen() {
        document.getElementById("result").value = "";
    }

    function backspace() {
        var currentValue = document.getElementById("result").value;
        document.getElementById("result").value = currentValue.slice(0, -1);
    }


    function sin() {
        var x = document.getElementById("result").value;
        document.getElementById("result").value = Math.sin(x);
    }

    function cos() {
        var x = document.getElementById("result").value;
        document.getElementById("result").value = Math.cos(x);
    }

    function tan() {
        var x = document.getElementById("result").value;
        document.getElementById("result").value = Math.tan(x);
    }

    function sqrt() {
        var x = document.getElementById("result").value;
        document.getElementById("result").value = Math.sqrt(x);
    }

    function square() {
        var x = document.getElementById("result").value;
        document.getElementById("result").value = x * x;
    }

    function log() {
        var x = document.getElementById("result").value;
        document.getElementById("result").value = Math.log10(x);
    }