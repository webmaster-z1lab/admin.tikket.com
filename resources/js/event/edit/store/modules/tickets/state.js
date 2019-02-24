export default {
    ticket: {
        id: null,
        name: '',
        free_ticket: false,
        summary: '',
        starts_at: '',
        quant_min: 1,
        quant_max: 5,
        lots: [
            {
                amount: '',
                finishes_at: '',
                value: 0
            }
        ]
    },
    coupons:[],
    coupon: {
        id: null,
        entrance_id: '',
        tag: '',
        is_percentage: false,
        validate_at: '',
        code: '',
        discount: 0,
        reuse: 1
    }
}
