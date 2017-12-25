
function isNumberKey(e)
{
    // Some browsers use e.which, others use e.keyCode
    var charCode = e.which ? e.which : e.keyCode;

    // number 0~9
    if(charCode >= 48 && charCode <= 57)
    {
        return true;
    }

    return false;
}


$("input[type=number]").keypress(function(e)
{
    return isNumberKey(e);
});

// constrain lower bound and upper bound
$('input[type=number]').on('keyup keypress blur change', function(e)
{
    var max = parseInt($(this).attr('max'));
    var min = parseInt($(this).attr('min'));
    var thisValue = $(this).val();
    if(thisValue > max)
    {
        $(this).val(max);
    }
    else if(thisValue < min)
    {
        $(this).val(min);
    }
});
