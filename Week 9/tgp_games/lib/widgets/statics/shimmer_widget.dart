import 'package:flutter/material.dart';
import 'package:shimmer/shimmer.dart';
import 'package:tgp_games/helpers/consts.dart';

class ShimmerWidget extends StatelessWidget {
  const ShimmerWidget({super.key});

  @override
  Widget build(BuildContext context) {
    return ClipRRect(
      borderRadius: BorderRadiusGeometry.circular(12),
      child: SizedBox(
        child: Shimmer.fromColors(
          baseColor: primaryColor.withValues(alpha: 0.33),
          highlightColor: purpleColor.withValues(alpha: 0.66),
          child: Center(child: Container(color: Colors.white)),
        ),
      ),
    );
  }
}
