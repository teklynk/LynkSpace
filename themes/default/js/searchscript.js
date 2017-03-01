// getSearchString (version #, this, domain, config, branch, searchBoxType [ls2, kids5, kids, classic]?, new window?)
function getSearchString(e, t, n, r, i, s, o) {
    var u;
    try {
        var a = inputValidator(e, n, r, i);
        n = a.domain;
        r = a.config;
        i = a.branch;
        searchTerm = t.elements["term"].value;
        switch (e) {
            case 3:
                switch (s) {
                    case "ls2":
                        if (searchTerm == "") {
                            searchString = n + "/?config=" + r + "#section=home" + i
                        } else {
                            searchString = n + "/?config=" + r + "#section=search&term=" + searchTerm + i
                        }
                        if (/Android|webOS|iPhone|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
                            searchString = n + "/mobile?config=" + r + "#section=search&term=" + searchTerm + i;
                            if (searchTerm == "") {
                                searchString = n + "/mobile?config=" + r + "#section=home" + i
                            }
                        }
                        break;
                    case "kids5":
                        if (searchTerm == "") {
                            searchString = n + "/kids?config=" + r + "#/categories"
                        } else {
                            searchString = n + "/kids?config=" + r + "#/search?searchString=" + searchTerm
                        }
                        break;
                    case "kids":
                        if (searchTerm == "") {
                            searchString = n + "/kids/?config=" + r + "&section=home"
                        } else {
                            searchString = n + "/kids?config=" + r + "&section=search&term=" + searchTerm
                        }
                        break;
                    case "classic":
                        if (searchTerm == "") {
                            searchString = n + "/TLCScripts/interpac.dll?home&Config=" + r
                        } else {
                            searchString = n + "/TLCScripts/interpac.dll?search&Config=" + r + "&SearchField=1&SearchType=1&SearchData=" + searchTerm
                        }
                        break
                }
                break;
            case 2:
                if (s == true) {
                    searchString = n + "/kids?config=" + r + "#/search?searchString=" + searchTerm;
                    if (searchTerm == "") {
                        searchString = n + "/kids?config=" + r + "#/categories"
                    }
                } else {
                    searchString = n + "/?config=" + r + "#section=search&term=" + searchTerm + i;
                    if (searchTerm == "") {
                        searchString = n + "/?config=" + r + "#section=home" + i
                    }
                    if (/Android|webOS|iPhone|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
                        searchString = n + "/mobile?config=" + r + "#section=search&term=" + searchTerm + i;
                        if (searchTerm == "") {
                            searchString = n + "/mobile?config=" + r + "#section=home" + i
                        }
                    }
                }
                break
        }
        if (o == true) {
            window.open(searchString)
        } else {
            window.location = searchString
        }
    } catch (f) {
        alert("An error has occurred. Please check your search box settings.\n\nError Message: '" + f.message + "' Line: " + f.lineNumber)
    }
    return false
}
function getScoutLink(e, t, n, r, i) {
    var s;
    try {
        var o = inputValidator(e, t, n, r);
        t = o.domain;
        n = o.config;
        branchFilter = o.branch;
        switch (e) {
            case 3:
                s = t + "/kids?config=" + n + "#/categories";
                break;
            case 2:
                s = t + "/kids?config=" + n + "#/categories";
                break
        }
        if (i == true) {
            window.open(s)
        } else {
            window.location = s
        }
    } catch (u) {
        alert("An error has occurred. Please check your search box settings.\n\nError Message: '" + u.message + "' Line: " + u.lineNumber)
    }
    return false
}
function inputValidator(e, t, n, r) {
    if (e === undefined) {
        throw new Error("Version number undefined in calling function.")
    }
    if (t === undefined) {
        throw new Error("Domain is undefined.")
    }
    if (n === undefined) {
        throw new Error("Config is undefined.")
    }
    if (n.substring(0, 7) == "config=") {
        n = n.substring(7, n.length)
    }
    if (t.substring(0, 7) == "http://" || t.substring(0, 8) == "https://") {} else {
        t = "http://" + t
    }
    if (t.substring(t.length - 1, t.length) == "/") {
        t = t.substring(0, t.length - 1)
    }
    if (r == "") {
        r = ""
    } else {
        r = r.replace(/, /g, "', '");
        r = "&branchFilters=['" + r + "']"
    }
    return {
        domain: t,
        config: n,
        branch: r
    }
}