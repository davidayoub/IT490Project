import random

class CryptoExchange:
    def __init__(self):
        self.balances = {'USD': 100000, 'BTC': 0, 'ETH': 0}

    def check_balance(self, currency):
        return self.balances[currency]

    def buy_crypto(self, currency, amount, price):
        cost = amount * price
        if self.balances['USD'] >= cost:
            self.balances[currency] += amount
            self.balances['USD'] -= cost
            return True
        else:
            return False

    def sell_crypto(self, currency, amount, price):
        if self.balances[currency] >= amount:
            earnings = amount * price
            self.balances[currency] -= amount
            self.balances['USD'] += earnings
            return True
        else:
            return False

    def display_balance(self):
        print("Your Balances:")
        for currency, balance in self.balances.items():
            print(f"{currency}: {balance:.2f}")

def main():
    exchange = CryptoExchange()
    print("Welcome to the Coin Market Exchange Simulator!")

    while True:
        print("\nMenu:")
        print("1. Check Balance")
        print("2. Buy Crypto")
        print("3. Sell Crypto")
        print("4. Exit")

        choice = input("Enter your choice: ")

        if choice == '1':
            currency = input("Enter currency (USD, BTC, ETH): ")
            balance = exchange.check_balance(currency)
            print(f"Your balance in {currency}: {balance:.2f}")

        elif choice == '2':
            currency = input("Enter the currency to buy (BTC or ETH): ")
            amount = float(input("Enter the amount to buy: "))
            price = random.uniform(1000, 50000)  # Simulated price
            success = exchange.buy_crypto(currency, amount, price)
            if success:
                print(f"Successfully bought {amount} {currency} at ${price:.2f} each.")
            else:
                print("Insufficient USD balance to buy.")

        elif choice == '3':
            currency = input("Enter the currency to sell (BTC or ETH): ")
            amount = float(input("Enter the amount to sell: "))
            price = random.uniform(1000, 50000)  # Simulated price
            success = exchange.sell_crypto(currency, amount, price)
            if success:
                print(f"Successfully sold {amount} {currency} at ${price:.2f} each.")
            else:
                print(f"Insufficient {currency} balance to sell.")

        elif choice == '4':
            exchange.display_balance()
            print("Thank you for using Coin Market Exchange Simulator! Goodbye.")
            break

if __name__ == "__main__":
    main()
