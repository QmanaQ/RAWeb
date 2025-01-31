import { useLaravelReactI18n } from 'laravel-react-i18n';
import type { FC } from 'react';

import { StringifiedUserPreference } from '@/common/utils/generatedAppConstants';

import { SectionFormCard } from '../SectionFormCard';
import { PreferencesSwitchField } from './PreferencesSwitchField';
import { usePreferencesSectionForm } from './usePreferencesSectionForm';

interface PreferencesSectionCardProps {
  currentWebsitePrefs: number;
  onUpdateWebsitePrefs: (newWebsitePrefs: number) => unknown;
}

export const PreferencesSectionCard: FC<PreferencesSectionCardProps> = ({
  currentWebsitePrefs,
  onUpdateWebsitePrefs,
}) => {
  const { t } = useLaravelReactI18n();

  const { form, mutation, onSubmit } = usePreferencesSectionForm(
    currentWebsitePrefs,
    onUpdateWebsitePrefs,
  );

  return (
    <SectionFormCard
      t_headingLabel={t('Preferences')}
      formMethods={form}
      onSubmit={onSubmit}
      isSubmitting={mutation.isPending}
    >
      <div className="grid gap-x-36 gap-y-6 md:grid-cols-2">
        <PreferencesSwitchField
          t_label={t('Suppress mature content warnings')}
          fieldName={StringifiedUserPreference.Site_SuppressMatureContentWarning}
          control={form.control}
        />

        <PreferencesSwitchField
          t_label={t('Show absolute dates on forum posts')}
          fieldName={StringifiedUserPreference.Forum_ShowAbsoluteDates}
          control={form.control}
        />

        <PreferencesSwitchField
          t_label={t('Hide missable achievement indicators')}
          fieldName={StringifiedUserPreference.Game_HideMissableIndicators}
          control={form.control}
        />

        <PreferencesSwitchField
          t_label={t('Only people I follow can message me or post on my wall')}
          fieldName={StringifiedUserPreference.User_OnlyContactFromFollowing}
          control={form.control}
        />

        {import.meta.env.VITE_FEATURE_MULTISET === 'true' ? (
          <PreferencesSwitchField
            t_label={t('Automatically opt in to all game sets')}
            fieldName={StringifiedUserPreference.Game_OptOutOfAllSets}
            control={form.control}
            isSwitchInverted={true}
          />
        ) : null}
      </div>
    </SectionFormCard>
  );
};
