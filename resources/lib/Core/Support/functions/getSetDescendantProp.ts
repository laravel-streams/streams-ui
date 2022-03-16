export function getSetDescendantProp(items, key, value?) {

    var keys = key ? key.split('.') : [];

    while ( keys.length && items ) {

        var compare = keys.shift();
        var match   = new RegExp('(.+)\\[([0-9]*)\\]').exec(compare);

        // handle arrays
        if ( (match !== null) && (match.length == 3) ) {

            var arrayData = {
                arrName : match[ 1 ],
                arrIndex: match[ 2 ],
            };

            if ( items[ arrayData.arrName ] !== undefined ) {
                if ( typeof value !== 'undefined' && keys.length === 0 ) {
                    items[ arrayData.arrName ][ arrayData.arrIndex ] = value;
                }
                items = items[ arrayData.arrName ][ arrayData.arrIndex ];
            } else {
                items = undefined;
            }

            continue;
        }

        // handle regular things
        if ( typeof value !== 'undefined' ) {
            if ( items[ compare ] === undefined ) {
                items[ compare ] = {};
            }

            if ( keys.length === 0 ) {
                items[ compare ] = value;
            }
        }

        items = items[ compare ];
    }

    return items;
}
