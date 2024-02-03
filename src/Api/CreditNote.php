<?php
/*
 * CreditNote.php
 * @author Martin Appelmann <hello@martin-appelmann.de>
 * @copyright 2022 Martin Appelmann
 */

namespace Exlo89\LaravelSevdeskApi\Api;

use Exception;
use Exlo89\LaravelSevdeskApi\Api\Utils\ApiClient;
use Exlo89\LaravelSevdeskApi\Api\Utils\DocumentHelper;
use Exlo89\LaravelSevdeskApi\Api\Utils\Routes;
use Exlo89\LaravelSevdeskApi\Constants\CreditNoteStatus;
use Exlo89\LaravelSevdeskApi\Models\SevCreditNote;
use Illuminate\Support\Collection;

/**
 * Sevdesk Credit Note Api
 *
 * @see https://api.sevdesk.de/#tag/CreditNote
 */
class CreditNote extends ApiClient
{
    // =========================== all ====================================

    /**
     * Return all credit notes.
     *
     * @return Collection
     */
    public function all(): Collection
    {
        return Collection::make($this->_get(Routes::CREDIT_NOTE));
    }

    /**
     * Return all draft credit notes.
     *
     * @return Collection
     */
    public function allDraft(): Collection
    {
        return Collection::make($this->_get(Routes::CREDIT_NOTE, ['status' => CreditNoteStatus::DRAFT]));
    }

    /**
     * Return all delivered credit notes.
     *
     * @return Collection
     */
    public function allDelivered(): Collection
    {
        return Collection::make($this->_get(Routes::CREDIT_NOTE, ['status' => CreditNoteStatus::DELIVERED]));
    }

    /**
     * Return all payed credit notes.
     *
     * @return Collection
     */
    public function allPayed(): Collection
    {
        return Collection::make($this->_get(Routes::CREDIT_NOTE, ['status' => CreditNoteStatus::PAYED]));
    }

    /**
     * Return all credit notes filtered by a date equal or lower.
     *
     * @param int $timestamp
     * @return Collection
     */
    public function allBefore(int $timestamp): Collection
    {
        return Collection::make($this->_get(Routes::CREDIT_NOTE, ['endDate' => $timestamp]));
    }

    /**
     * Return all credit notes filtered by a date equal or higher.
     *
     * @param int $timestamp
     * @return Collection
     */
    public function allAfter(int $timestamp): Collection
    {
        return Collection::make($this->_get(Routes::CREDIT_NOTE, ['startDate' => $timestamp]));
    }

    /**
     * Return all credit notes filtered by a date range.
     *
     * @param int $startTimestamp
     * @param int $endTimestamp
     * @return Collection
     */
    public function allBetween(int $startTimestamp, int $endTimestamp): Collection
    {
        return Collection::make($this->_get(Routes::CREDIT_NOTE, [
            'startDate' => $startTimestamp,
            'endDate'   => $endTimestamp,
        ]));
    }

    // =========================== create ====================================

    /**
     * Create credit note.
     *
     * @param $contactId
     * @param $items
     * @param array $parameters
     * @return mixed
     * @throws Exception
     */
    public function create($contactId, $items, array $parameters = []): SevCreditNote
    {
        // generate a new number and header if creditNoteNumber is not set
        if (empty($parameters['creditNoteNumber'])) {
            $nextSequence = $this->getNextSequence(self::CREDIT_NOTE);
            $parameters['creditNoteNumber'] = $nextSequence;
            $parameters['header'] = 'Gutschrift NR. ' . $nextSequence;
        }
        // create parameter array
        $creditNoteParameters = DocumentHelper::getCreditNoteParameters($contactId, $items, $parameters);
        $response = $this->_post(Routes::CREATE_CREDIT_NOTE, $creditNoteParameters);
        // create model with relationships
        /** @var SevCreditNote $sevCreditNote */
        $sevCreditNote = SevCreditNote::make($response['creditNote']);
        $sevCreditNote->setRelation('invoicePositions', collect($response['creditNotePos']));
        return $sevCreditNote;
    }

    /**
     * Create credit note from invoice id.
     *
     * @param string $invoiceId
     * @return mixed
     */
    public function createFromInvoice(string $invoiceId): SevCreditNote
    {
        $response = $this->_post(Routes::CREATE_CREDIT_NOTE_FROM_INVOICE, [
            'invoice' => [
                'id'         => $invoiceId,
                'objectName' => 'Invoice'
            ]
        ]); // create model with relationships
        /** @var SevCreditNote $sevCreditNote */
        $sevCreditNote = SevCreditNote::make($response['creditNote']);
        $sevCreditNote->setRelation('positions', collect($response['creditNotePos']));
        return $sevCreditNote;
    }

    // =======================================================================

    /**
     * Returns pdf file of the giving credit note id.
     *
     * @return void
     */
    public function download($creditNoteId)
    {
        $this->getPdf(Routes::CREDIT_NOTE . '/' . $creditNoteId . '/getPdf');
    }

    /**
     * Send credit note per email.
     *
     * @return void
     */
    public function sendByMail($creditNoteId, $email, $subject, $text)
    {
        return $this->_post(Routes::CREDIT_NOTE . '/' . $creditNoteId . '/sendViaEmail', [
            'toEmail' => $email,
            'subject' => $subject,
            'text'    => $text,
        ]);
    }
}
