<!DOCTYPE html>
<html>
    <head>
        <title>TODO supply a title</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    </head>
    <body>
        <br/>
        <br/>
        <br/>
        <div style="text-align: center;">
            <input type="number" id="t1" value="0">
            <input type="number" id="t2" value="0" >
            <input type="number" id="t3" value="0" >
            <input type="number" id="t4" value="0" >
        </div>
        <br/>
        <div style="text-align: center;">
            <input type="number" id="b1" value="0">
            <input type="number" id="b2" value="0" >
            <input type="number" id="b3" value="0" >
            <input type="number" id="b4" value="0" >
        </div>
        <br/>
        <div style="text-align: center;">
            <input type="button" id="cal" value="คำนวณ">
        </div>
        <br/>
        <div id="result" style="text-align: center;">

        </div>
        <br/>
        <div style="text-align: center;">
            <textarea rows="20"></textarea>
        </div>
    </body>
</html>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script>
    $('body').on('click', '#cal', function (e) {

        var ar = [];

        var t1 = $('#t1').val();
        var t2 = $('#t2').val();
        var t3 = $('#t3').val();
        var t4 = $('#t4').val();
        var b1 = $('#b1').val();
        var b2 = $('#b2').val();
        var b3 = $('#b3').val();
        var b4 = $('#b4').val();

        var ar1 = t1 + t2 + '</br>';
        var ar2 = t1 + t3 + '</br>';
        var ar3 = t1 + t4 + '</br>';
        var ar4 = t2 + t3 + '</br>';
        var ar5 = t2 + t4 + '</br>';
        var ar6 = t3 + t4 + '</br>';

        var ar7 = b1 + b2 + '</br>';
        var ar8 = b1 + b3 + '</br>';
        var ar9 = b1 + b4 + '</br>';
        var ar10 = b2 + b3 + '</br>';
        var ar11 = b2 + b4 + '</br>';
        var ar12 = b3 + b4 + '</br>';

        //////////////////////////////////////////////////////////////////////////////////////////////

        var ar13 = t1 + b1 + '</br>';
//        var ar14 = t1 + b2 + '</br>';
//        var ar15 = t1 + b3 + '</br>';
        var ar16 = t1 + b4 + '</br>';
//
//        var ar17 = t2 + b1 + '</br>';
        var ar18 = t2 + b2 + '</br>';
        var ar19 = t2 + b3 + '</br>';
//        var ar20 = t2 + b4 + '</br>';
//
//        var ar21 = t3 + b1 + '</br>';
        var ar22 = t3 + b2 + '</br>';
        var ar23 = t3 + b3 + '</br>';
//        var ar24 = t3 + b4 + '</br>';
//
        var ar25 = t4 + b1 + '</br>';
//        var ar26 = t4 + b2 + '</br>';
//        var ar27 = t4 + b3 + '</br>';
        var ar28 = t4 + b4 + '</br>';

        $('#result').html(ar1 + ar2 + ar3 + ar4 + ar5 + ar6 + ar7 + ar8 + ar9 + ar10 + ar11 + ar12 + ar13 + ar16 + ar18 + ar19 + ar22 + ar23 + ar25 + ar28);
    });
</script>
