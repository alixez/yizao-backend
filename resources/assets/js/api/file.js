/**
 * Created by alixez on 17-4-4.
 */
import api from './api';

class file extends api {

    constructor() {
        super();
    }

    static getUploadImageAction(disk='default', width=null, height=null) {
        if (width && height) {
            return this.Host + 'files/image/upload/' + disk + '/w/' + width + '/h/' + height;
        }

        return this.Host + 'files/image/upload/' + disk;
    }
}

export default file;