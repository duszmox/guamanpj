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

function getBackData(inputValue, type) {
    switch (type) {
        case "money":
            newValue = inputValue.toLowerCase();
            newValue = newValue.replace(/\s/g, '');
            newValue = newValue.replace("/ft/g", ""); // TODO (?) global currency
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