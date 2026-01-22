import 'package:flutter/material.dart';
import 'package:flutter_animate/flutter_animate.dart';
import 'package:provider/provider.dart';
import 'package:saees_cards/helpers/consts.dart';
import 'package:saees_cards/helpers/functions_helper.dart';
import 'package:saees_cards/models/wallet_model.dart';
import 'package:saees_cards/providers/auth_provider.dart';
import 'package:saees_cards/providers/transaction_provider.dart';
import 'package:saees_cards/widgets/statics/shimmer_widget.dart';
import 'package:saees_cards/widgets/statics/transaction_details.dart';

class WalletContent extends StatefulWidget {
  const WalletContent({super.key});

  @override
  State<WalletContent> createState() => _WalletContentState();
}

class _WalletContentState extends State<WalletContent> {
  @override
  void initState() {
    Provider.of<AuthProvider>(context, listen: false).getWallet();
    Provider.of<TransactionsProvider>(context, listen: false).getTransactions();
    Provider.of<TransactionsProvider>(context, listen: false).setLisnter();
    super.initState();
  }

  @override
  Widget build(BuildContext context) {
    return Consumer2<AuthProvider, TransactionsProvider>(
      builder: (context, authConsumer, transactionsConsumer, _) {
        return SafeArea(
          child: Column(
            children: [
              AnimatedSwitcher(
                duration: 300.ms,
                child: authConsumer.busy || authConsumer.walletModel == null
                    ? SizedBox(
                        height: getSize(context).height * 0.24,
                        child: Padding(
                          padding: const EdgeInsets.all(16.0),
                          child: ShimmerWidget(),
                        ),
                      )
                    : DigitalCard(walletModel: authConsumer.walletModel!),
              ),

              transactionsConsumer.transactions.isNotEmpty
                  ? Expanded(
                      child: ListView.builder(
                        controller: transactionsConsumer.controller,
                        itemCount: transactionsConsumer.transactions.length + 1,
                        itemBuilder: (context, index) {
                          if (index <
                              transactionsConsumer.transactions.length) {
                            final transaction =
                                transactionsConsumer.transactions[index];
                            return TransactionDetails(
                              ammount: transaction.amount,
                              refrence: transaction.reference,
                              type: transaction.type,
                              username: transaction.user.name,
                              description: transaction.description,
                            );
                          } else {
                            return Padding(
                              padding: EdgeInsetsGeometry.all(8),
                              child: Center(
                                child: SizedBox(
                                  height: 24,
                                  width: 24,
                                  child: CircularProgressIndicator(
                                    strokeWidth: 2.5,
                                  ),
                                ),
                              ),
                            );
                          }
                        },
                      ),
                    )
                  : SizedBox(),
            ],
          ),
        );
      },
    );
  }
}

class DigitalCard extends StatelessWidget {
  const DigitalCard({super.key, required this.walletModel});
  final WalletModel walletModel;
  @override
  Widget build(BuildContext context) {
    return Padding(
      padding: const EdgeInsets.all(16.0),
      child: Container(
        decoration: BoxDecoration(
          color: primaryColor,

          borderRadius: BorderRadius.circular(16),
        ),

        child: Padding(
          padding: const EdgeInsets.all(16.0),
          child: Column(
            mainAxisSize: MainAxisSize.min,
            children: [
              Row(
                mainAxisAlignment: MainAxisAlignment.spaceBetween,
                children: [
                  Image.asset(
                    "assets/chip.png",
                    width: getSize(context).width * 0.15,
                  ),

                  Padding(
                    padding: const EdgeInsets.symmetric(horizontal: 8),
                    child: Text(
                      walletModel.name,
                      style: labelMedium.copyWith(color: whiteColor),
                    ),
                  ),
                ],
              ),

              SizedBox(height: 70),

              Row(
                mainAxisAlignment: MainAxisAlignment.spaceBetween,
                children: [
                  Text(
                    DateTime.now()
                        .add(Duration(days: 365))
                        .toString()
                        .substring(2, 7)
                        .replaceAll("-", "/"),
                    style: labelMedium.copyWith(color: whiteColor),
                  ),

                  Text(
                    "${walletModel.balance} LYD",
                    style: labelMedium.copyWith(color: whiteColor),
                  ),
                ],
              ),
            ],
          ),
        ),
      ),
    );
  }
}
