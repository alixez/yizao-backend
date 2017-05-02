/**
 * Created by alixez on 17-4-4.
 */
import pkg from 'package';

class api {
    static Host = pkg.env.apiHost;

    constructor() {

    }

    getHost() {
        return this.Host;
    }
}

export default api;