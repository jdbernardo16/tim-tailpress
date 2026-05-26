# True Influence Method — Development Estimate

## All Pages in the Figma

| #   | Page                                     | Type                        | Template?     |
| --- | ---------------------------------------- | --------------------------- | ------------- |
| 1   | True Influence Method — Home             | Homepage                    | Custom        |
| 2   | The Journey Scrolled                     | Homepage section            | Custom        |
| 3   | The Journey Animation                    | Homepage section (animated) | Custom        |
| 4   | Homepage Final CTA Animation             | Homepage section (animated) | Custom        |
| 5   | Watch Joanna Speak Modal                 | Modal overlay               | Custom        |
| 6   | Events and Workshops                     | Content listing             | Custom        |
| 7   | About Joanna                             | Bio + email subscribe       | Custom        |
| 8   | On Stage                                 | Speaking portfolio          | Custom        |
| 9   | Success Stories                          | Testimonials / case studies | Custom        |
| 10  | FAQS ANSWERS                             | Accordion FAQ               | Custom        |
| 11  | Inquiry                                  | Booking contact form        | Custom        |
| 12  | The Vault                                | Free community / event      | Custom        |
| 13  | Offers index                             | All offerings overview      | Custom        |
| 14  | $29 Million Dollar Message               | Free training product       | Custom        |
| 15  | Tell Your Story (Phase 1)                | Program page                | ✅ Template   |
| 16  | Move the Room / Speaker Cohort (Phase 2) | Program page                | ✅ Template   |
| 17  | Master My Message (Phase 3)              | Program page                | ✅ Template   |
| 18  | Build My Team (Phase 4)                  | Program page                | ✅ Template   |
| 19  | Be Remembered (Phase 5)                  | Program page                | ✅ Template   |
| 20  | Breakthrough Session                     | Standalone offering         | Semi-template |
| 21  | 4-Session Training Package               | Bundle offering             | Semi-template |
| 22  | Private Client                           | High-end offering           | Semi-template |
| 23  | Move the Room / Speaker Cohort Checkout  | Checkout                    | ✅ Template   |
| 24  | Master My Message Checkout               | Checkout                    | ✅ Template   |
| 25  | Build My Team Checkout                   | Checkout                    | ✅ Template   |
| 26  | Be Remembered Checkout                   | Checkout                    | ✅ Template   |
| 27  | Breakthrough Session Checkout            | Checkout                    | ✅ Template   |
| 28  | Private Client Checkout                  | Checkout                    | ✅ Template   |
| 29  | The Vault Thank You                      | Thank you                   | ✅ Template   |
| 30  | Move the Room Thank You                  | Thank you                   | ✅ Template   |
| 31  | Master My Message Thank You              | Thank you                   | ✅ Template   |
| 32  | Breakthrough Session Thank You           | Thank you                   | ✅ Template   |
| 33  | Build My Team Thank You                  | Thank you                   | ✅ Template   |
| 34  | Be Remembered Thank You                  | Thank you                   | ✅ Template   |
| 35  | Inquiry Thank You                        | Thank you                   | ✅ Template   |
| 36  | On Stage Thank You                       | Thank you                   | ✅ Template   |
| 37  | $29M Message Thank You                   | Thank you                   | ✅ Template   |
| 38  | Work With Me Dropdown                    | Nav component               | Reusable      |
| 39  | FORBES / ABC                             | Press badge                 | Reusable      |

---

## Repetition Patterns

-   **5 Phase program pages** — ~95% identical layout (text/images differ)
-   **6 Checkout pages** — ~90% identical (price & product name differ)
-   **9 Thank You pages** — ~85% identical (product name & messaging differ)

---

## Features Requiring Backend / CRUD / Forms

| Feature                    | Pages Involved                                             |
| -------------------------- | ---------------------------------------------------------- |
| Contact/Inquiry form       | Inquiry                                                    |
| Email subscribe            | About Joanna                                               |
| Checkout & Payment Gateway | All 6 checkout pages (Stripe/Apple Pay, pricing up to $1M) |
| Event listing CRUD         | Events and Workshops                                       |
| Testimonial CRUD           | Success Stories                                            |
| FAQ CRUD                   | FAQS ANSWERS                                               |
| Auth / User accounts       | The Vault (registration)                                   |
| Content management         | All 5 Phase program pages                                  |
| Navigation dropdown        | Work With Me dropdown                                      |

---

## Time Estimates

### Manual vs AI-Assisted

| Category            | Item                                           | Template?   | Manual       | AI-Assisted            |
| ------------------- | ---------------------------------------------- | ----------- | ------------ | ---------------------- |
| **Homepage**        | True Influence Method — Home                   | No          | 2 days       | 4 hrs                  |
|                     | The Journey Scrolled + Animation + Final CTA   | No          | 1 day        | 2 hrs                  |
|                     | Watch Joanna Speak Modal                       | No          | 0.5 day      | 1 hr                   |
| **Content Pages**   | Events and Workshops                           | No          | 0.5 day      | 1 hr                   |
|                     | About Joanna (with subscribe)                  | No          | 0.5 day      | 1.5 hrs                |
|                     | On Stage                                       | No          | 0.5 day      | 1 hr                   |
|                     | Success Stories                                | No          | 0.5 day      | 1 hr                   |
|                     | Offers index                                   | No          | 0.5 day      | 1 hr                   |
|                     | The Vault (with registration)                  | No          | 0.5 day      | 1.5 hrs                |
|                     | $29 Million Dollar Message                     | No          | 0.5 day      | 1 hr                   |
|                     | FAQS ANSWERS (accordion)                       | No          | 0.25 day     | 30 min                 |
|                     | Inquiry (contact form)                         | No          | 0.5 day      | 1 hr                   |
| **Program Pages**   | Phase 1-5 (Tell Your Story → Be Remembered)    | ✅ Template | 1 day        | 2 hrs                  |
|                     | Breakthrough Session                           | Semi        | 0.5 day      | 1 hr                   |
|                     | 4-Session Training Package                     | Semi        | 0.25 day     | 30 min                 |
|                     | Private Client                                 | Semi        | 0.25 day     | 30 min                 |
| **Checkout Pages**  | All 6 checkouts                                | ✅ Template | 1.5 days     | 2 hrs                  |
| **Thank You Pages** | All 9 thank you pages                          | ✅ Template | 0.5 day      | 30 min                 |
| **UI Components**   | Work With Me Dropdown                          | Reusable    | 0.25 day     | 15 min                 |
|                     | Press badges (FORBES/ABC)                      | Reusable    | 0.25 day     | 15 min                 |
| **Backend**         | Stripe / Payment Gateway                       | —           | 2 days       | 1 day                  |
|                     | Auth / User Accounts                           | —           | 1.5 days     | 4 hrs                  |
|                     | CMS CRUD (Events, Testimonials, FAQ, Programs) | —           | 2.5 days     | 4 hrs                  |
|                     | Email / Subscribe Integration                  | —           | 0.5 day      | 1 hr                   |
| **Animations**      | Scroll + phase card animations                 | —           | 1 day        | 2 hrs                  |
| **QA**              | Responsive + Cross-browser + Bug fixes         | —           | 2 days       | 4 hrs                  |
|                     | **TOTAL**                                      |             | **~21 days** | **~2.5 days (20 hrs)** |

---

## Key Observations

-   **88% faster** with AI assistance — biggest wins come from template pages (5 programs, 6 checkouts, 9 thank yous all share ~90% identical layout)
-   **Payment gateway still ~1 day** — Stripe config, webhooks, and test-mode validation need human oversight
-   **Auth + CRUD backend reduced from ~4 days to ~8 hours** — AI generates all boilerplate routes, controllers, and admin UIs
-   **Animations** (scroll-triggered phase cards, CTAs) are the most manual-intensive frontend item at 2 hours
