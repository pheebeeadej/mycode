def refund_order(modeladmin, request, queryset):
    for order in queryset:
        if not "FAILED" in order.product and not "Monnify Funding" in order.product:
            order.user.deposit(order.user.id, float(order.amount),False ,"REFUND")
            
            Wallet_summary.objects.create(user=order.user,create_date=order.create_date, product=f"{order.product} - REFUNDED", amount=order.amount, previous_balance=order.user.Account_Balance, after_balance=(order.user.Account_Balance + float(order.amount)))
            order.product = f"{order.product} - FAILED"
            order.save()
            
            
refund_order.short_description = 'Refund selected Order'
​
​
class WalletAdmin(admin.ModelAdmin):
    list_display = ('user', 'product', 'amount','balance_before',"balance_after",'create_date')
    actions = [refund_order, ] 
    search_fields = ['user__username','product',]
​
    def balance_before(self, obj):
        return  "{:,}".format(round(float(obj.previous_balance),2))
​
    def balance_after(self, obj):
        return  "{:,}".format(round(float(obj.after_balance),2))