import * as types from '../../mutation-types'

import {toSeek, exceptionError} from "../../../../../vendor/common";

export default {
    setAccesses(context, payload) {
        toSeek(payload)
            .then(response => {
                context.dispatch('changeLoading', false)
                context.commit(types.SET_ACCESSES, response.data)
            })
            .catch((error) => exceptionError(error))
    }
}
