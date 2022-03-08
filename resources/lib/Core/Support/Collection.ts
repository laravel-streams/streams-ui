export class Collection<Type> extends Array<Type> implements Array<Type> {

    /**
     * Create a new collection instance.
     *
     * @param items
     */
    constructor(...items: Type[]) {

        super(...items);

        Object.assign(this, Array.prototype);
    }
}
