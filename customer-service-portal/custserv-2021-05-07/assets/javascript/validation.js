function isEmpty(fieldValue) {
    if (fieldValue == null || fieldValue == "" || fieldValue == "Select One") {
        return true;
    } else {
        return false;
    }
}

function validEmail(fieldValue) {
    if (!/.+?@.+?\..+/.test(fieldValue)) {
        return false;
    } else {
        return true;
    }
}

function checkPhone(fieldValue) {
    if (!/^\(?([0-9]{3})\)?[-. ]?([0-9]{3})[-. ]?([0-9]{4})$/.test(fieldValue)) {
        return true;
    } else {
        return false;
    }
}

function validPhone(fieldValue, label) {
    let format = /^\(?([0-9]{3})\)?[ ]?[-]?([0-9]{3})[-]?([0-9]{4})$/;

    if (!format.test(fieldValue)) {
        return false;
    } else {
        let phone = fieldValue.replace(format, "($1) $2-$3");

        if (label == "phone") {
            document.getElementById("phone").value = phone;
        } else {
            document.getElementById("contact-phone").value = phone;
        }

        return true;
    }
}

function isEqual(fieldValue1, fieldValue2) {
    if (fieldValue1 === fieldValue2) {
        return true;
    } else {
        return false;
    }
}

function radioChecked(fieldValue) {
    if (fieldValue.checked == true) {
        return true;
    } else {
        return false;
    }
}

function hasDuplicates(array) {
    console.log(array);
    for (let i = 0; i <= array.length; i++) {
        for (let j = i; j <= array.length; j++) {
            if (i != j && array[i] == array[j]) {
                console.log(array[i]);
                console.log(array[j]);
                return true;
            }
        }
    }
    return false;
}