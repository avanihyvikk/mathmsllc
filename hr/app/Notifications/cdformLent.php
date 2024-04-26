<?php

namespace Modules\cdform\Notifications;

use App\Notifications\BaseNotification;
use Modules\cdform\Entities\cdform;
use Modules\cdform\Entities\cdformHistory;

class cdformLent extends BaseNotification
{
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    private $cdform;

    private $history;

    public function __construct(cdform $cdform, cdformHistory $history)
    {
        $this->cdform = $cdform;
        $this->history = $history;
        $this->company = $this->cdform->company;

    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    //phpcs:ignore
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return parent::build()
            ->subject(__('cdform::app.cdformLent'))
            ->greeting(__('email.hello').' '.$notifiable->name.'!')
            ->line(__('cdform::app.cdformLentMessageForMail'))
            ->line(__('cdform::app.cdformName').': '.$this->cdform->name)
            ->line(__('cdform::app.dateGiven').': '.$this->history->date_given->format('d F Y H:i A'))
            //phpcs:ignore
            ->line(__('cdform::app.returnDate').': '.(! is_null($this->history->return_date) ? $this->history->return_date->format('d F Y H:i A') : '-'))
            ->line(__('cdform::app.lendBy').': '.$this->history->lender->name)
            ->line(__('cdform::app.notes').': '.(! is_null($this->history->notes) ? $this->history->notes : '-'))
            ->line(__('email.thankyouNote'));
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    //phpcs:ignore
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
