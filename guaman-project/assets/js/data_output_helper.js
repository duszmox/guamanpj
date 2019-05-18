function getCellBody(value, col_type, canEdit) {
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

                withzero = (value + "").length === 1 ? "0" + value : value;
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
                cell_body += "<span>" + cell_value + "</span>";
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
        default:
            if (canEdit) {
                cell_body = "<input type=\"text\" class=\"form-control data-cell\" value=\'" + value + "\'>";
                cell_body += "<span hidden>" + value + "</span>";
            } else {
                cell_body = "<span>" + value + "</span>";
            }
    }
    return cell_body;
}

// TODO megcsinálni, hogy JS-ből is tudjunk langot kiolvasni
var MONTHS = ["Január", "Február", "Március", "Április", "Május", "Június", "Július", "Augusztus", "Szeptember", "Október", "November", "December"];

function getDisplayFormat(value, type) {
    console.log("type: " + type + "; value: " + value);
    switch (type) {
        case "month":
            value += "";
            while (value.charAt(0) === '0') {
                value = value.substr(1);
            }
            if (value > MONTHS.length) {
                console.log("Invalid month number!");
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