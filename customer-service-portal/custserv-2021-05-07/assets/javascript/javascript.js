function hideBody() {
    if (document.getElementById("main-navbar").classList.contains("show") === false) {
        // document.getElementById("breadcrumb-menu").classList.add("hide");
        // document.getElementById("main-content").classList.add("hide");
        // document.getElementById("name-container").classList.add("hide");
        // document.getElementById("footer").classList.add("hide");
    } else {
        // document.getElementById("breadcrumb-menu").classList.remove("hide");
        // document.getElementById("main-content").classList.remove("hide");
        // document.getElementById("name-container").classList.remove("hide");
        // document.getElementById("footer").classList.remove("hide");
    }
};

// document.getElementById("mobile-menu-button").addEventListener("click", hideBody);

let toggle = document.getElementsByClassName('navbar-toggler')[0],
    collapse = document.getElementsByClassName('navbar-collapse')[0];

function toggleMenu() {
    collapse.classList.toggle('collapse');
    collapse.classList.toggle('show');
}

function closeMenusOnResize() {
    if (document.body.clientWidth >= 768) {
        collapse.classList.add('collapse');
        collapse.classList.remove('show');
    }
}

window.addEventListener('resize', closeMenusOnResize, false);

if (toggle) {
    toggle.addEventListener('click', toggleMenu, false);
}

function hideBody() {
    if (document.getElementById("close-menu").classList.contains("hide")) {
        document.getElementById("close-menu").classList.remove("hide");
        document.getElementById("open-menu").classList.add("hide");
    } else {
        document.getElementById("close-menu").classList.add("hide");
        document.getElementById("open-menu").classList.remove("hide");
    }
};

function view_user(id) {
    console.log(id);

    let view_user = document.getElementById("view-id");
    view_user.value = id;

    document.forms["view-user-form"].submit();
}

function delete_user(id) {
    let delete_user = document.getElementById("delete-id");
    delete_user.value = id;

    document.forms["delete-user-form"].submit();
}

function view_company(id) {
    let view_company = document.getElementById("view-id");
    view_company.value = id;

    document.forms["view-company-form"].submit();
}

function delete_company(id) {
    console.log(id);

    let delete_company = document.getElementById("delete-company-id");
    delete_company.value = id;

    document.forms["delete-company-form"].submit();
}

let hide_mobile = document.getElementById("mobile-menu-button");

if (hide_mobile) {
    hide_mobile.addEventListener("click", hideBody);
}

function validateEditUserForm() {

    let required_inputs = [
        "account-number",
        "contract-name",
        "contract-id",
        "invoice-number"
    ];

    for (i = 0; i < required_inputs.length; i++) {
        let form_field_inputs = document.forms["contract-search-form"][required_inputs[i]];

        if (isEmpty(form_field_inputs.value)) {
            form_field_inputs.classList.add("is-invalid");
        } else {
            if (form_field_inputs.classList.contains("is-invalid")) {
                form_field_inputs.classList.remove("is-invalid");
            }

            form_field_inputs.classList.add("is-valid");
        }
    }

    return false;
}

function validateLoginForm() {
    let errors = [];
    
    let required_inputs = [
        "username",
        "password"
    ];

    for (i = 0; i < required_inputs.length; i++) {
        let form_field_inputs = document.forms["login-form"][required_inputs[i]];
        let labels = document.getElementsByTagName('LABEL');
        let label = labels[i].innerHTML;
        
        if (isEmpty(form_field_inputs.value)) {
            form_field_inputs.classList.add("is-invalid");

            errors.push("The " + label + " field cannot be empty");
        } else {
            if (form_field_inputs.classList.contains("is-invalid")) {
                form_field_inputs.classList.remove("is-invalid");
            }

            form_field_inputs.classList.add("is-valid");
        }
    }

    if (errors.length > 0) {
        return false;
    }

    return;
}

function validateCreateUserForm() {
    let errors = [];

    let required_inputs = [
        "role",
        "username",
        "first-name",
        "last-name",
        "email",
        "confirm-email",
        "password",
        "confirm-password"
    ];

    for (i = 0; i < required_inputs.length; i++) {
        let form_field_inputs = document.forms["create-user-form"][required_inputs[i]];
        let labels = document.getElementsByTagName('LABEL');
        let label = labels[i].innerHTML;

        if (isEmpty(form_field_inputs.value)) {
            form_field_inputs.classList.add("is-invalid");
            form_field_inputs.nextElementSibling.innerText = label + " is required.";

            errors.push("The " + label + " field cannot be empty");
        } else {
            if (form_field_inputs.classList.contains("is-invalid")) {
                form_field_inputs.classList.remove("is-invalid");
            }

            form_field_inputs.classList.add("is-valid");
        }
    }

    let email = document.getElementById("email");
    let confirm_email = document.getElementById("confirm-email");

    if (isEmpty(email.value) == false && validEmail(email.value) == false) {
        email.classList.add("is-invalid");
        email.nextElementSibling.innerText = "Email is required and must be valid.";
        
        errors.push("Email is required and must be valid.");
    } else if (isEmpty(email.value) == false && validEmail(email.value)) {
        if (email.classList.contains("is-invalid")) {
            email.classList.remove("is-invalid");
        }

        email.classList.add("is-valid");
    }

    if (isEmpty(confirm_email.value) == false && validEmail(confirm_email.value) == false) {
        confirm_email.classList.add("is-invalid");
        confirm_email.nextElementSibling.innerText = "Confirm Email is required and must be valid.";
        
        errors.push("Confirm Email is required and must be valid.");
    } else if (isEmpty(confirm_email.value) == false && validEmail(confirm_email.value)) {
        if (confirm_email.classList.contains("is-invalid")) {
            confirm_email.classList.remove("is-invalid");
        }

        confirm_email.classList.add("is-valid");
    }

    if (errors.length > 0) {
        return false;
    }

    return;
}