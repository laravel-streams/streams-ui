export type KindsOf =
    'number'
    | 'string'
    | 'boolean'
    | 'function'
    | 'regexp'
    | 'array'
    | 'date'
    | 'error'
    | 'object'
let kindsOf = {};
'Number String Boolean Function RegExp Array Date Error'.split(' ').forEach(function (k) {
    kindsOf[ '[object ' + k + ']' ] = k.toLowerCase();
});

export function kindOf(value: any): KindsOf {
    // Null or undefined.
    if ( value == null ) {
        return String(value) as any;
    }
    // Everything else.
    return kindsOf[ kindsOf.toString.call(value) ] || 'object';
}


export const isNumber   = (value: any): value is number => kindOf(value) === 'number';
export const isString   = (value: any): value is string => kindOf(value) === 'string';
export const isBoolean  = (value: any): value is boolean => kindOf(value) === 'boolean';
export const isFunction = (value: any): value is Function => kindOf(value) === 'function';
export const isRegExp   = (value: any): value is RegExp => kindOf(value) === 'regexp';
export const isArray    = (value: any): value is Array<any> => kindOf(value) === 'array';
export const isDate     = (value: any): value is Date => kindOf(value) === 'date';
export const isError    = (value: any): value is Error => kindOf(value) === 'error';
export const isObject   = (value: any): value is object => kindOf(value) === 'object';
export const isNothing  = (value: any): value is undefined | null => value === null || typeof value === undefined;

// export function isNumericString(str): boolean {
//     if ( typeof str !== 'string' ) return false; // we only process strings!
//     return !isNaN(str);
//     //&& // use type coercion to parse the _entirety_ of the string (`parseFloat` alone does not do this)...
//     //  !isNaN(parseFloat(str)) // ...and ensure strings of whitespace fail
// }

export const isNumericString = (value: any): boolean => isString(value) && !isNaN(value as any);
export const isStringNumber  = (value: any): value is string | number => isNumber(value) || isNumericString(value);

export function isNumberObject(target): boolean {
    if ( Array.isArray(target) ) return false;
    if ( !isObject(target) ) return false;
    let keys       = Object.keys(target);
    let numberKeys = keys.filter(val => isNumericString(val));
    return keys.length === numberKeys.length;
}

/** @see https://stackoverflow.com/questions/27746304/how-do-i-tell-if-an-object-is-a-promise */
export function isES6Promise(p) {
    return p && Object.prototype.toString.call(p) === "[object Promise]";
}
export function isNativePromise(p) {
    return p && typeof p.constructor === "function"
        && Function.prototype.toString.call(p.constructor).replace(/\(.*\)/, "()")
        === Function.prototype.toString.call(/*native object*/Function)
                    .replace("Function", "Promise") // replacing Identifier
                    .replace(/\(.*\)/, "()"); // removing possible FormalParameterList
}
export function isPromise<T = any>(p):p is PromiseLike<T>{
    return isES6Promise(p) || isNativePromise(p);
}
