import * as types from '../../mutation-types'

import {toSeek, exceptionError} from "../../../../../vendor/common";

export default {
    setTicket(context, payload) {
        context.commit(types.SET_TICKETS, payload)
    },
    setCoupon(context, payload) {
        context.commit(types.SET_COUPON, payload)
    },
    setCoupons(context, payload) {
        toSeek(payload)
            .then(response => context.commit(types.SET_COUPONS, response.data))
            .catch((error) => exceptionError(error))
    }
}
