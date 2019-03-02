import React from 'react';
import Dotdotdot from 'react-dotdotdot';
import Button from 'components/common/Button';
import { news as newsConstants } from 'constants/js/countItems';

export default function News(props) {
  const { data } = props;

  return (
    <div className="card mb-3">
      <div className="card-body">
        <h5 className="card-title text-truncate">{data.headline}</h5>
        <Dotdotdot clamp={newsConstants.countLinesInBody}>
          <p className="card-text">{data.summary}</p>
        </Dotdotdot>
        <a href={data.url} className="w-100 mt-3" target="_blank">
          <Button
            text="Learn more"
            size="small"
            color="green"
            className="m-0 w-100 mt-3"
          />
        </a>
      </div>
    </div>
  );
}
