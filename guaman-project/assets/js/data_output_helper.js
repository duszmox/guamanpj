function getCellBody(value, col_type, canEdit, customData) {
    let cell_body = "";
    switch (col_type) {
        case "text":
            if (canEdit) {
                cell_body = "<input type=\"text\" class=\"form-control data-cell\" value=\'" + value + "\'>";
                cell_body += "<span hidden>" + value + "</span>";
            } else {
                cell_body = "<span>" + value + "</span>";
            }
            break;
        case "month":
            if (canEdit) {
                // TODO select input
                cell_body = "<input type=\"text\" class=\"form-control data-cell\" value=\'" + value + "\'>";
                cell_body += "<span hidden>" + value + "</span>";
            } else {

                let withzero = (value + "").length === 1 ? "0" + value : value;
                cell_body = "<span><span hidden>" + withzero + "</span>" + getDisplayFormat(value, "month") + "</span>";
            }
            break;
        case "date":
            if (canEdit) {
                cell_body = "<input type=\"date\" class=\"form-control data-cell\" value=\'" + value + "\'>";
                cell_body += "<span hidden>" + value + "</span>";
            } else {
                cell_body = "<span>" + value + "</span>";
            }
            break;
        case "money":
            let cell_value = value;
            if (isNumeric(cell_value)) {
                cell_value = numberWithSpaces(cell_value);
            } else {
                cell_value = "0";
                value = "0";
            }

            if (canEdit) {
                cell_body = "<input type=\"text\" pattern=\'[0-9]|\\s\' value=\'" + cell_value + "\' class=\'form-control\'/>";
                cell_body += "<span hidden>" + cell_value + " " + value + "</span>";
            } else {
                cell_body = "<span>" + cell_value + "</span>";
                cell_body += "<span hidden>" + cell_value + " " + value + "</span>";
            }
            break;
        case "percentage":
            if (canEdit) {
                value += "";
                cell_body = "<input type=\"text\" class=\"form-control data-cell\" value=\'" + value + "%\'>";
                cell_body += "<span hidden>" + value + "%</span>";
            } else {
                cell_body = "<span>" + value + "%</span>";
            }
            break;

        case "enum":

            let enumName = customData.sourceEnum;

            var options = getEnum(enumName);

            // options = getEnum();
            if (canEdit) {
                cell_body = "<select class='form-control data-cell'>";
                for (let i = 0; i < options.length; i++) {
                    if (value === options[i].value) {
                        cell_body += "<option value='" + options[i].value + "' selected>" + options[i].nice_value + "</option>";
                    } else {
                        cell_body += "<option value='" + options[i].value + "'>" + options[i].nice_value + "</option>";
                    }
                }
                cell_body += "</select>";
            } else {
                let nice_value = "Nincs megadva"; // TODO lang
                for (let i = 0; i < options.length; i++) {
                    if (options[i].value === value) {
                        nice_value = options[i].nice_value;
                        break;
                    }
                }
                cell_body += "<span>" + nice_value + "</span>";
            }
            break;
        default:
            if (canEdit) {
                cell_body = "<input type=\"text\" class=\"form-control data-cell\" value=\'" + value + "\'>";
                cell_body += "<span hidden>" + value + "</span>";
            } else {
                cell_body = "<span>" + value + "</span>";
            }
            break;
    }
    return cell_body;
}

// TODO megcsinálni, hogy JS-ből is tudjunk langot kiolvasni
const MONTHS = ["Január", "Február", "Március", "Április", "Május", "Június", "Július", "Augusztus", "Szeptember", "Október", "November", "December"];


var enums = {};

function getEnum(enumName) {
    if (enums[enumName] === undefined) {
        $.ajax({
            url: base_url + "database/get-enum/" + enumName,
            success: function (data) {
                enums[enumName] = data;
                enums[enumName].push({
                    id: -1,
                    value: "",
                    nice_value: "Nincs megadva" // TODO lang
                });
            },
            async: false,
            method: "GET"
        }).fail(function () {
            internetConnectionProblemAlert();
        });
    }

    return enums[enumName];


}

function getDisplayFormat(value, type) {
    switch (type) {
        case "month":
            value += "";
            while (value.charAt(0) === '0') {
                value = value.substr(1);
            }
            if (value > MONTHS.length) {
                Toast.fire({
                    title: "Invalid month number!",
                    type: "error"
                })
                ;
            } else {
                value = MONTHS[value - 1];
            }
            break;
        case "percentage":
            value += "%";
            break;

    }
    return value;
}

function getBackData(inputValue, type) {
    let newValue = "";
    switch (type) {
        case "money":
            newValue = inputValue.toLowerCase();
            newValue = newValue.replace(/\s/g, '');
            newValue = newValue.replace("/ft/g", ""); // TODO (?) global currency
            break;
        case "percentage":
            newValue = inputValue.replace(/\s/g, '');
            newValue = newValue.replace(/%/g, '');
            if (!isNumeric(newValue)) {
                alert("Invalid percentage!"); // TODO lang
            }
            break;

        default:
            newValue = inputValue;
    }
    return newValue;
}

function numberWithSpaces(number) {
    let parts = number.toString().split(".");
    parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, " ");
    return parts.join(".");
}