namespace App\Enums;

enum TransferStatus: string {
    case PENDING = 'pending';
    case COMPLETED = 'completed';
    case EXPIRED = 'expired';
}
